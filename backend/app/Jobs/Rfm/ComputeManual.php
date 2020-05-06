<?php

namespace App\Jobs\Rfm;

use App\Models\Data;
use App\Services\DTO\RfmDTO;
use Closure;
use Illuminate\Support\Facades\Auth;

class ComputeManual
{
    public function handle(RfmDTO $rfmDTO, Closure $next)
    {
        $quantiles = $this->getQuantiles($rfmDTO->getRfmTable());
        $classifications = $this->makeAndSaveClassification($rfmDTO->getRfmTable(), $quantiles, $rfmDTO->userId);
        $rfmDTO->setClassification($classifications);

        return $next($rfmDTO);
    }

    /**
     * @param array $array
     * @return array
     */
    protected function getQuantiles(array $array): array
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

    /**
     * @param array $array
     * @param string $attribute
     * @return array
     */
    protected function extractAttribute(array $array, string $attribute): array
    {
        $result = [];
        foreach ($array as $item) {
            $result[] = $item[$attribute];
        }

        return $result;
    }

    /**
     * @param array $array
     * @return float|int|mixed
     */
    protected function quartile_25(array $array)
    {
        return $this->quartile($array, 0.25);
    }

    /**
     * @param array $array
     * @return float|int|mixed
     */
    protected function quartile_50(array $array)
    {
        return $this->quartile($array, 0.5);
    }

    /**
     * @param array $array
     * @return float|int|mixed
     */
    protected function quartile_75(array $array)
    {
        return $this->quartile($array, 0.75);
    }

    /**
     * @param array $array
     * @param float $quartile
     * @return float|int|mixed
     */
    protected function quartile(array $array, float $quartile)
    {
        sort($array);
        $pos = (count($array) - 1) * $quartile;

        $base = floor($pos);
        $rest = $pos - $base;

        if (isset($array[$base + 1])) {
            return $array[$base] + $rest * ($array[$base + 1] - $array[$base]);
        }
        else {
            return $array[$base];
        }
    }

    /**
     * @param array $rfmTable
     * @param array $quantiles
     * @return array
     */
    protected function makeAndSaveClassification(array $rfmTable, array $quantiles, int $userId): array
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

            Data::where('user_id', $userId)->where('client_id', $clientId)->update([
                'recency'   => $item['recency'],
                'frequency' => $item['frequency'],
                'monetary'  => $item['monetary'],
                'score'     => $temp['rfm_score']
            ]);
            $arr[] = $temp;
        }

        return $arr;
    }

    /**
     * @param array $datum
     * @param array $quantiles
     * @param string $type
     * @return int
     */
    protected function recencyClassification(array $datum, array $quantiles, string $type = 'recency'): int
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

    /**
     * @param array $datum
     * @param array $quantiles
     * @param string $type
     * @return int
     */
    protected function monetaryAndFrequencyClassification(array $datum, array $quantiles, string $type): int
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
}
