<?php

namespace App\Http\Resources;

use App\Models\Data;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource as Resource;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        $data = [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'client_id' => $this->client_id,
            'recency'   => $this->recency,
            'frequency' => $this->frequency,
            'monetary'  => $this->monetary,
            'score'     => $this->score,
            'ml'        => $this->kmeans
        ];

        return $data;
    }

}
