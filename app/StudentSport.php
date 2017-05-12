<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSport extends Model
{
    protected $table = 'student_sport';

    protected $fillable =[
        'student_id', 'session_id'
    ];

    public function absence() {
        return $this->hasOne(Absence::class);
    }
}
