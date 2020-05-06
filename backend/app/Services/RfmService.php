<?php

namespace App\Services;

use App\Models\Data;
use App\Models\RFM;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Phpml\Clustering\KMeans;

class RfmService
{
    /**
     * @return bool
     * @throws \Phpml\Exception\InvalidArgumentException
     */
    public function calculateRfm(): bool
    {
        $data = Data::where('user_id', Auth::id())->get(['client_id', 'amount', 'ordered_at', 'email']);
        $rfmTable = $this->constructRfmTable($data);
        $dataset = $this->getDataset($rfmTable);
        $this->computeAndSaveKMeans($dataset);
        $quantiles = $this->getQuantiles($rfmTable);
        $classifications = $this->makeAndSaveClassification($rfmTable, $quantiles);
        $ml = $this->saveMlDataset();
        $this->saveDataset($classifications, $ml);

        return true;
    }

    /**
     * @param array $dataset
     * @throws \Phpml\Exception\InvalidArgumentException
     */
    protected function computeAndSaveKMeans(array $dataset)
    {
        $kmeans = new KMeans(4);

        $clusters = $kmeans->cluster($dataset);

        foreach ($clusters as $key => $cluster) {
            foreach ($cluster as $email => $item) {
                Data::where('user_id', Auth::id())->where('email', $email)->update([
                    'kmeans' => $key + 1
                ]);
            }
        }
    }

    protected function constructRfmTable($data)
    {
        $uniqueUsers = $data->unique('client_id');

        $rfmTable = [];
        foreach ($uniqueUsers as $uniqueUser) {
            $rfmTable[$uniqueUser->client_id] = [
                'frequency' => $data->where('client_id', $uniqueUser->client_id)->count(),
                'recency'   => $this->getRecency($uniqueUser->client_id),
                'monetary'  => $data->where('client_id', $uniqueUser->client_id)->sum('amount'),
                'email'     => $uniqueUser->email
            ];
        }

        return $rfmTable;
    }

    /**
     * @param int $clientId
     * @return int
     * @throws \Exception
     */
    protected function getRecency(int $clientId)
    {
        $latestOrder = Data::where('user_id', Auth::id())
            ->where('client_id', $clientId)
            ->latest('ordered_at')
            ->first();
        $now = new Carbon();

        return $now->diffInDays(new Carbon($latestOrder->ordered_at));
    }

    protected function quartile_25($array)
    {
        return $this->quartile($array, 0.25);
    }

    protected function quartile_50($array)
    {
        return $this->quartile($array, 0.5);
    }

    protected function quartile_75($array)
    {
        return $this->quartile($array, 0.75);
    }

    protected function quartile($array, $quartile)
    {
        sort($array);
        $pos = (count($array) - 1) * $quartile;

        $base = floor($pos);
        $rest = $pos - $base;

        if (isset($array[$base + 1])) {
            return $array[$base] + $rest * ($array[$base + 1] - $array[$base]);
        } else {
            return $array[$base];

        }
    }

    protected function average($array)
    {
        return array_sum($array) / count($array);
    }

    protected function getQuantiles(array $array)
    {
        $frequency  = $this->extractAttribute($array, 'frequency');
        $recency    = $this->extractAttribute($array, 'recency');
        $monetary   = $this->extractAttribute($array, 'monetary');

        $quantiles = [
            'frequency' => [
                '0.25' => $this->quartile_25($frequency),
                '0.50' => $this->quartile_50($frequency),
                '0.75' => $this->quartile_75($frequency),
            ],
            'recency' => [
                '0.25' => $this->quartile_25($recency),
                '0.50' => $this->quartile_50($recency),
                '0.75' => $this->quartile_75($recency),
            ],
            'monetary' => [
                '0.25' => $this->quartile_25($monetary),
                '0.50' => $this->quartile_50($monetary),
                '0.75' => $this->quartile_75($monetary),
            ],

        ];

        return $quantiles;
    }

    protected function extractAttribute($array, $attribute)
    {
        $result = [];
        foreach ($array as $item) {
            $result[] = $item[$attribute];
        }

        return $result;
    }

    protected function recencyClassification(&$datum, $quantiles, $type = 'recency')
    {
        if($datum[$type] <= $quantiles[$type]['0.25']) {
            return 1;
        }
        elseif ($datum[$type] <= $quantiles[$type]['0.50']) {
            return 2;
        }
        elseif ($datum[$type] <= $quantiles[$type]['0.75']) {
            return 3;
        }
        else {
            return 4;
        }
    }

    protected function monetaryAndFrequencyClassification($datum, $quantiles, $type)
    {
        if($datum[$type] <= $quantiles[$type]['0.25']) {
            return 4;
        }
        elseif ($datum[$type] <= $quantiles[$type]['0.50']) {
            return 3;
        }
        elseif ($datum[$type] <= $quantiles[$type]['0.75']) {
            return 2;
        }
        else {
            return 1;
        }
    }


    protected function makeAndSaveClassification(array $rfmTable, array $quantiles)
    {
        $arr = [];
        foreach ($rfmTable as $clientId => $item) {
            $temp['r_quartile'] = $this->recencyClassification($item, $quantiles, 'recency');
            $temp['f_quartile'] = $this->monetaryAndFrequencyClassification($item, $quantiles, 'frequency');
            $temp['m_quartile'] = $this->monetaryAndFrequencyClassification($item, $quantiles, 'monetary');
            $temp['rfm_score'] = round(array_sum([$temp['r_quartile'], $temp['f_quartile'], $temp['m_quartile']]) / 3, 1)
            ;
            $temp['client_id'] = $clientId;
            $temp['email'] = $item['email'];
            $temp['recency'] = $item['recency'];
            $temp['monetary'] = $item['monetary'];
            $temp['frequency'] = $item['frequency'];

            Data::where('user_id', Auth::id())->where('client_id', $clientId)->update([
                'recency' => $item['recency'],
                'frequency' => $item['frequency'],
                'monetary' => $item['monetary'],
                'score' => $temp['rfm_score']
            ]);
            $arr[] = $temp;
        }

        return $arr;
    }

    public function saveDataset(array $classifications, array $ml)
    {
        $vHighRm  = [];
        $highRm   = [];
        $mediumRm = [];
        $lowRm    = [];
        $vHighRf  = [];
        $highRf   = [];
        $mediumRf = [];
        $lowRf    = [];

        foreach ($classifications as $class)
        {
            $score = $class['rfm_score'];
            if ($score < 2) {
                $vHighRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email'],
                ];
                $vHighRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email'],
                ];
            }
            elseif ($score >=2 && $score < 3) {
                $highRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email']
                ];
                $highRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email']
                ];
            }
            elseif ($score >=3 && $score < 4) {
                $mediumRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email']
                ];
                $mediumRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email']
                ];
            }
            elseif ($score == 4) {
                $lowRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email']
                ];
                $lowRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email']
                ];
            }

        }

        $data = [
            'rm' => [
                'v_high' => $vHighRm,
                'high'   => $highRm,
                'medium' => $mediumRm,
                'low'    => $lowRm,
            ],
            'rf' => [
                'v_high' => $vHighRf,
                'high'   => $highRf,
                'medium' => $mediumRf,
                'low'    => $lowRf,
            ]
        ];

        RFM::create([
            'user_id' => Auth::id(),
            'data'  => json_encode($data),
            'ml' => json_encode($ml)
        ]);
    }

    public function saveMlDataset()
    {

        $data = Data::where('user_id', Auth::id())->get();
        $classifications = $data->unique('client_id');
        $vHighRm  = [];
        $highRm   = [];
        $mediumRm = [];
        $lowRm    = [];
        $vHighRf  = [];
        $highRf   = [];
        $mediumRf = [];
        $lowRf    = [];

        foreach ($classifications as $class)
        {
            $score = $class['kmeans'];
            if ($score == 1) {
                $vHighRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email'],
                ];
                $vHighRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email'],
                ];
            }
            elseif ($score == 2) {
                $highRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email']
                ];
                $highRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email']
                ];
            }
            elseif ($score ==3) {
                $mediumRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email']
                ];
                $mediumRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email']
                ];
            }
            elseif ($score == 4) {
                $lowRm[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary'],
                    'u' => $class['email']
                ];
                $lowRf[] = [
                    'x' => $class['recency'],
                    'y' => $class['frequency'],
                    'u' => $class['email']
                ];
            }

        }

        $data = [
            'rm' => [
                'first_cluster'     => $vHighRm,
                'second_cluster'    => $highRm,
                'third_cluster'     => $mediumRm,
                'fourth_cluster'    => $lowRm,
            ],
            'rf' => [
                'first_cluster'     => $vHighRf,
                'second_cluster'    => $highRf,
                'third_cluster'     => $mediumRf,
                'fourth_cluster'    => $lowRf,
            ]
        ];

        return $data;
    }

    protected function getDataset(array $rfmTable)
    {
        $arr = [];
        foreach ($rfmTable as $item) {
            $arr[$item['email']] = [$item['recency'], $item['frequency'], $item['monetary']];
        }

        return $arr;
    }
}
