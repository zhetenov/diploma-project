<?php

namespace App\Jobs;

use App\Jobs\Mailing\DeleteEmailsFile;
use App\Jobs\Mailing\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    protected $subject;

    /** @var string */
    protected $fileName;

    /** @var $message */
    protected $message;

    /**
     * SendEmailJob constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->subject = $data['subject'];
        $this->message = $data['message'];
        $this->createFile($data['emails']);
    }

    /**
     * @return array
     */
    public function loadPipes(): array
    {
        return [
            SendMessage::class,
            DeleteEmailsFile::class
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
            ->send(['file_name' => $this->fileName, 'subject' => $this->subject, 'message' => $this->message])
            ->through($this->loadPipes())
            ->thenReturn();
    }

    /**
     * @param array $emails
     */
    protected function createFile(array $emails): void
    {
        $this->fileName = uniqid('public/emails/').'.txt';
        Storage::put($this->fileName, implode("\n", $emails));
    }
}
