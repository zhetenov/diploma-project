<?php

namespace App\Jobs\Mailing;

use Closure;
use Illuminate\Support\Facades\Storage;

class DeleteEmailsFile
{
    public function handle(array $content, Closure $next)
    {
        Storage::delete($content['file_name']);

        return $next($content);
    }
}
