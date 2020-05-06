<?php

namespace App\Http\Controllers\Api;

use App\Helper\Status;
use App\Http\Controllers\Controller;
use App\Jobs\CalculateRfmJob;
use App\Models\RFM;
use Illuminate\Support\Facades\Auth;

class RfmController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function calculateRfm()
    {
        CalculateRfmJob::dispatch(Auth::id());

        return response('Successfully');
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getRfmData()
    {
        $data = RFM::where('user_id', Auth::id())->first();

        if(!isset($data)) {
            return response([]);
        }

        if($data->status == Status::PROCESSING) {
            return response(['status' => Status::PROCESSING]);
        }
        $manual = json_decode($data->data);
        $ml     = json_decode($data->ml);
        $manualCounts = [count($manual->rf->v_high), count($manual->rf->high), count($manual->rf->medium), count($manual->rf->low)];
        $mlCounts = [count($ml->rf->first_cluster), count($ml->rf->second_cluster), count($ml->rf->third_cluster), count($ml->rf->fourth_cluster)];

        return response([
            'manual'=> $manual,
            'ml'    => $ml,
            'stat'  => [
                'manual' => [
                    'vh'    => $manualCounts[0],
                    'h'     => $manualCounts[1],
                    'm'     => $manualCounts[2],
                    'l'     => $manualCounts[3],
                    'amount' => array_sum($manualCounts),
                ],
                'ml'     => [
                    'vh'    => $mlCounts[0],
                    'h'     => $mlCounts[1],
                    'm'     => $mlCounts[2],
                    'l'     => $mlCounts[3],
                ]
            ],
            'status' => $data->status
        ]);
    }
}
