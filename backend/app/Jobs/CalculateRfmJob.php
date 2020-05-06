<?php

namespace App\Jobs;

use App\Jobs\Rfm\ComputeKMeans;
use App\Jobs\Rfm\ComputeManual;
use App\Jobs\Rfm\ContstructRfmTable;
use App\Jobs\Rfm\DeleteOldRfmData;
use App\Jobs\Rfm\InitRfm;
use App\Jobs\Rfm\SaveDataset;
use App\Models\RFM;
use App\Services\DTO\RfmDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CalculateRfmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    protected $user_id;

    /**
     * @return array
     */
    public function loadPipes(): array
    {
        return [
            DeleteOldRfmData::class,
            InitRfm::class,
            ContstructRfmTable::class,
            ComputeKMeans::class,
            ComputeManual::class,
            SaveDataset::class
        ];
    }

    public function __construct($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $dto = new RfmDTO();
            $dto->userId = $this->user_id;

            app(Pipeline::class)
                ->send($dto)
                ->through($this->loadPipes())
                ->thenReturn();
        } catch (\Exception $exception) {
            RFM::where('user_id', Auth::id())->delete();
        }
    }
}
