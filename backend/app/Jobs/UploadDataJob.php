<?php

namespace App\Jobs;

use App\Jobs\Upload\SaveData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var integer */
    protected $userId;

    /** @var string */
    protected $fileName;

    /**
     * UploadDataJob constructor.
     * @param int $userId
     * @param array $csv
     */
    public function __construct(int $userId, array $csv)
    {
        $this->userId = $userId;
        $this->createFile($csv);
    }

    /**
     * @return array
     */
    public function loadPipes(): array
    {
        return [
            SaveData::class,
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(Pipeline::class)
            ->send(['file_name' => $this->fileName, 'user_id' => $this->userId])
            ->through($this->loadPipes())
            ->thenReturn();
    }

    /**
     * @param array $csv
     */
    protected function createFile(array $csv): void
    {
        $this->fileName = uniqid('public/data/');
        Storage::put($this->fileName, serialize($csv));
    }
}
