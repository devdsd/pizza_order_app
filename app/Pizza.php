<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    // New Code
    protected $fillable = [
        'user_id', 'customer_name', 'type', 'crust'
    ];
}
