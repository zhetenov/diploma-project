<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFM extends Model
{
    protected $table = 'rfm';

    protected $fillable = ['user_id', 'data', 'ml', 'status'];
}
