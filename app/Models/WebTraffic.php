<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebTraffic extends Model
{
    protected $table = 'web_traffics';

    protected $fillable = [
        'date',
        'visits',
    ];
}
