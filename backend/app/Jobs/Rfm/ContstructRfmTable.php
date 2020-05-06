<?php

namespace App\Jobs\Rfm;

use App\Models\Data;
use App\Services\DTO\RfmDTO;
use Carbon\Carbon;
use Closure;

class ContstructRfmTable
{
    public function handle(RfmDTO $rfmDTO,Closure $next)
    {
        $data = Data::where('user_id', $rfmDTO->userId)->get(['client_id', 'amount', 'ordered_at', 'email']);
        if (empty($data)) {
            //TODO: error
        }
        $rfmTable = $this->constructRfmTable($data, $rfmDTO->userId);
        $rfmDTO->setRfmTable($rfmTable);

        return $next($rfmDTO);
    }

    /**
     * @param $data
     * @return array
     */
    protected function constructRfmTable($data, $userId): array
    {
        $uniqueUsers = $data->unique('client_id');

        $rfmTable = [];
        foreach ($uniqueUsers as $uniqueUser) {
            $rfmTable[$uniqueUser->client_id] = [
                'frequency' => $data->where('client_id', $uniqueUser->client_id)->count(),
                'recency'   => $this->getRecency($uniqueUser->client_id, $userId),
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
    protected function getRecency(int $clientId, int $userId)
    {
        $latestOrder = Data::where('user_id', $userId)
            ->where('client_id', $clientId)
            ->latest('ordered_at')
            ->first();
        $now = new Carbon();

        return $now->diffInDays(new Carbon($latestOrder->ordered_at));
    }
}
