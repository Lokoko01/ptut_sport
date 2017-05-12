<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable =[
        'studentSport_id', 'date'
    ];
}
