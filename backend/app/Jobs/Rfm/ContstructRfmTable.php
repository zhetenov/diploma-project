<?php

namespace App\Jobs\Rfm;

use App\Models\Data;
use App\Services\DTO\RfmDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Closure;

class ContstructRfmTable
{
    public function handle(RfmDTO $rfmDTO,Closure $next)
    {
        $data = Data::where('user_id', Auth::id())->get(['client_id', 'amount', 'ordered_at', 'email']);
        if (empty($data)) {
            //TODO: error
        }
        $rfmTable = $this->constructRfmTable($data);
        $rfmDTO->setRfmTable($rfmTable);

        return $next($rfmDTO);
    }

    /**
     * @param $data
     * @return array
     */
    protected function constructRfmTable($data): array
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
}
