<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'timeSlot_id', 'sport_id', 'professor_id', 'location_id', 'max_seat'
    ];
}
