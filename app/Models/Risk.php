<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $fillable = [
        'risk_name',
        'description',
        'likelihood',
        'consequences',
        'risk_level',
    ];
}
