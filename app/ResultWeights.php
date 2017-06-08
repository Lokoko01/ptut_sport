<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultWeights extends Model
{
    protected $table = 'result_weights';

    protected $fillable = [
        'student_id', 'weight', 'student_wishes_id'
    ];
}
