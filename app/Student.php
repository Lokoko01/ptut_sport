<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable =[
        'ufr_id', 'studentNumber','privateEmail',
    ];

    public function ufr() {
        return $this->hasOne(Ufr::class);
    }
    public function myId(){
        return $this->id;
    }

}
