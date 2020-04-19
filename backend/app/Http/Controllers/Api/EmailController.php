<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendEmailRequest;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    public function sendEmail(SendEmailRequest $request)
    {
        SendEmailJob::dispatch($request->validated());

        return response('successfully sent');
    }
}
