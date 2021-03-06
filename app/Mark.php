<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table = 'marks';

    protected $fillable =[
        'student_sport_id', 'mark', 'comment'
    ];

    public function mark() {
        return $this->hasOne(Mark::class);
    }
}
