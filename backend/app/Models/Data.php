<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = ['user_id', 'client_id', 'amount', 'ordered_at', 'email', 'name'];

    public function getDataByClientId(int $clientId) {
        return Data::where('client_id', $clientId)->get();
    }
}
