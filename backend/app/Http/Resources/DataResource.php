<?php

namespace App\Http\Resources;

use App\Models\Data;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource as Resource;
use Illuminate\Support\Facades\Auth;

class DataResource extends Resource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        $data = [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'client_id' => $this->client_id,
            'data'      => $this->getDataByClientId($this->client_id),
        ];

        return $data;
    }

    /**
     * @param int $clientId
     * @return array
     * @throws \Exception
     */
    protected function getDataByClientId(int $clientId)
    {
        $data = Data::where('client_id', $clientId)->where('user_id', Auth::id())->get([
            'id', 'amount', 'ordered_at'
        ]);

        // Годовой оборот
        $annual = $this->getAnnualTurnover($data);
        // Недельный оборот
        $weekly = $this->getWeeklyTurnover($data);

        return [
            'all'                   => $data->toArray(),
            'annual_turnover'       => $annual[0],
            'annual_transactions'   => $annual[1],
            'weekly_turnover'       => $weekly[0],
            'weekly_transactions'   => $weekly[1]
        ];
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    protected function getAnnualTurnover($data)
    {
        $amount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $transactions = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($data as $datum) {
            $amount[(new Carbon($datum['ordered_at']))->month] += $datum['amount'];
            $transactions[(new Carbon($datum['ordered_at']))->month] += 1;
        }

        return [$amount, $transactions];
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    protected function getWeeklyTurnover($data)
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
        $transactions = [0, 0, 0, 0, 0, 0, 0];

        foreach ($data as $datum) {
            $amount[$weekMap[(new Carbon($datum['ordered_at']))->minDayName]] += $datum['amount'];
            $transactions[$weekMap[(new Carbon($datum['ordered_at']))->minDayName]] += 1;
        }

        return [$amount, $transactions];
    }
}
