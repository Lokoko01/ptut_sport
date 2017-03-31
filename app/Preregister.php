<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preregister extends Model
{
    protected $table = 'user_preregister';

    protected $fillable =[
        'email', 'token',
    ];
}
