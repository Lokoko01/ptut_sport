<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSlots extends Model
{
    protected $table = 'timeSlots';

    protected $fillable = [
        'dayOfWeek', 'startTime', 'endTime'
    ];
}
