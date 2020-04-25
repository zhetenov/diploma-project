<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RFM;
use App\Services\RfmService;
use Illuminate\Support\Facades\Auth;

class RfmController extends Controller
{
    /**
     * @param RfmService $service
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function calculateRfm(RfmService $service)
    {
        RFM::where('user_id', Auth::id())->delete();
        $service->calculateRfm();

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
        return response([json_decode($data->data)]);
    }
}
