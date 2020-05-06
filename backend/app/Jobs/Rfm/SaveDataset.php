<?php

namespace App\Jobs\Rfm;

use App\Helper\Status;
use App\Models\Data;
use App\Models\RFM;
use App\Services\DTO\RfmDTO;
use Closure;

class SaveDataset
{
    public function handle(RfmDTO $rfmDTO, Closure $next)
    {
        $mlDataset = $this->getMlDataset($rfmDTO->userId);
        $manualDataset = $this->getManualDataset($rfmDTO->getClassification());

        RFM::where('user_id', $rfmDTO->userId)->update([
            'data'      => json_encode($manualDataset),
            'ml'        => json_encode($mlDataset),
            'status'    => Status::FINISHED
        ]);

        return $next($rfmDTO);
    }

    public function getMlDataset(int $userId)
    {
        $data = Data::where('user_id', $userId)->get();
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

    public function getManualDataset(array $classifications)
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

        return $data;
    }
}
