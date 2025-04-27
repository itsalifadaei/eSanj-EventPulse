<?php

namespace App\Models;

use PhpClickHouseLaravel\BaseModel;

class Event extends BaseModel
{
    protected $casts = [
        'happened_at' => "timestamp",
    ];
}
