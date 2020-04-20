<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = ['user_id', 'client_id', 'amount', 'ordered_at', 'email', 'name'];
}
