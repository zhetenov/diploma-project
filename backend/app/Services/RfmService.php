<?php

namespace App\Services;

use App\Models\Data;
use App\Models\RFM;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RfmService
{
    public function calculateRfm(): bool
    {
        $data = Data::where('user_id', Auth::id())->get(['client_id', 'amount', 'ordered_at']);
        $rfmTable = $this->constructRfmTable($data);
        $quantiles = $this->getQuantiles($rfmTable);
        $classifications = $this->makeAndSaveClassification($rfmTable, $quantiles);
        $this->saveDataset($classifications);

        return true;
    }

    protected function constructRfmTable($data)
    {
        $uniqueUsers = $data->unique('client_id');

        $rfmTable = [];
        foreach ($uniqueUsers as $uniqueUser) {
            $rfmTable[$uniqueUser->client_id] = [
                'frequency' => $data->where('client_id', $uniqueUser->client_id)->count(),
                'recency'   => $this->getRecency($uniqueUser->client_id),
                'monetary'  => $data->where('client_id', $uniqueUser->client_id)->sum('amount')
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

    public function saveDataset(array $classifications)
    {
        $vHigh  = [];
        $high   = [];
        $medium = [];
        $low    = [];

        foreach ($classifications as $class)
        {
            $score = $class['rfm_score'];
            if ($score < 2) {
                $vHigh[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary']
                ];
            }
            elseif ($score >=2 && $score < 3) {
                $high[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary']
                ];
            }
            elseif ($score >=3 && $score < 4) {
                $medium[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary']
                ];
            }
            elseif ($score == 4) {
                $low[] = [
                    'x' => $class['recency'],
                    'y' => $class['monetary']
                ];
            }

        }

        $data = [
            'v_high' => $vHigh,
            'high'   => $high,
            'medium' => $medium,
            'low'    => $low,
        ];

        RFM::create([
            'user_id' => Auth::id(),
            'data'  => json_encode($data)
        ]);
    }
}
