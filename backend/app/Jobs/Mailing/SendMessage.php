<?php

namespace App\Jobs\Mailing;

use App\Mail\UserMail;
use Closure;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\LazyCollection;

class SendMessage
{
    public function handle(array $content, Closure $next)
    {
        LazyCollection::make(function () use ($content) {
            $handle = fopen(storage_path('app/') . $content['file_name'], 'r');

            while (($line = fgets($handle)) !== false) {
                yield $line;
            }
        })->each(function ($email, $key) use ($content) {
            Mail::to(str_replace("\n", "", $email))->send(new UserMail($content['subject'], $content['message']));
        });
    }
}
