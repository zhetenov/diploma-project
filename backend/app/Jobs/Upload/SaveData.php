<?php

namespace App\Jobs\Upload;

use App\Models\Data;
use Closure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;

class SaveData
{
    public function handle(array $content, Closure $next)
    {
        LazyCollection::make(function () use ($content) {
            $handle = (fopen(storage_path('app/') . $content['file_name'], 'r'));

            while (($line = unserialize(fgets($handle))) !== false) {
                yield $line;
            }
        })->each(function ($client, $key) use ($content) {
            foreach ($client as $value) {
                Data::create([
                    'user_id'    => $content['user_id'],
                    'client_id'  => $value['client_id'],
                    'ordered_at' => $value['ordered_at'],
                    'amount'     => $value['amount'],
                    'email'      => $value['email'],
                    'name'       => $value['name']
                ]);
            }
        });

        Storage::delete($content['file_name']);

    }
}
