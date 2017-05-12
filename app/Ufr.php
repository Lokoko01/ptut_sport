<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ufr extends Model
{
    protected $table = 'ufr';

    protected $fillable =[
        'code','label'
    ];
}
