<?php

namespace App\Services;

use Carbon\Carbon;

class StatisticsService
{
    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function getStatistics($data): array
    {
        return [
            'annual_amount' => $this->getMonthlyTransactions($data),
            'weekly_amount' => $this->getWeeklyAmount($data)
        ];
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    private function getMonthlyTransactions($data): array
    {
        $amount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($data as $datum) {
            $amount[(new Carbon($datum['ordered_at']))->month - 1] += $datum['amount'];
        }

        return $amount;
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    private function getWeeklyAmount($data): array
    {
        $weekMap = [
            'Mo' => 0,
            'Tu' => 1,
            'We' => 2,
            'Th' => 3,
            'Fr' => 4,
            'Sa' => 5,
            'Su' => 6
        ];

        $amount = [0, 0, 0, 0, 0, 0, 0];

        foreach ($data as $datum) {
            $amount[$weekMap[(new Carbon($datum['ordered_at']))->minDayName]] += $datum['amount'];
        }

        return $amount;
    }
}
