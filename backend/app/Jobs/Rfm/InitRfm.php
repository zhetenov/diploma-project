<?php

namespace App\Jobs\Rfm;

use App\Helper\Status;
use App\Models\RFM;
use App\Services\DTO\RfmDTO;
use Closure;
use Illuminate\Support\Facades\Auth;

class InitRfm
{
    public function handle(RfmDTO $rfmDTO, Closure $next)
    {
         RFM::create([
            'user_id'   => $rfmDTO->userId,
            'data'      => '[]',
            'ml'        => '[]',
            'status'    => Status::PROCESSING
        ]);

        return $next($rfmDTO);
    }
}
