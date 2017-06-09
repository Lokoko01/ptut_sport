<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageInformation extends Model
{
    protected $table = 'messages';

    protected $fillable =[
        'message', 'session_id', 'type_user'
    ];

    public function mark() {
        return $this->hasOne(MessageInformation::class);
    }
}
