<?php

namespace App\Jobs\Rfm;

use App\Models\RFM;
use App\Services\DTO\RfmDTO;
use Illuminate\Support\Facades\Auth;
use Closure;

class DeleteOldRfmData
{
    public function handle(RfmDTO $rfmDTO, Closure $next)
    {
        RFM::where('user_id', $rfmDTO->userId)->delete();

        return $next($rfmDTO);
    }
}
