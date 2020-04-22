<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendEmailRequest;
use App\Http\Resources\StatisticsResource;
use App\Jobs\SendEmailJob;
use App\Models\Data;
use App\Services\StatisticsService;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    /**
     * @param StatisticsService $service
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function getStatistics(StatisticsService $service)
    {
        $data = Data::where('user_id', Auth::id())->get();

        return response([
            'sales' => count($data),
            'turnover' => $data->sum('amount'),
            'last_order' => $data->last()->ordered_at,
            'users' => $data->unique('client_id')->count(),
            'data' => $service->getStatistics($data)
        ]);
    }
}
