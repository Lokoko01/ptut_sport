<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait; // add this trait to your user model

    /**c
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'firstname', 'sex', 'studentNumber', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isStudent () {
        return $this->hasRole('student');
    }

    public function isAdmin () {
        return $this->hasrole('admin');
    }

    public function isProfessor (){
        return $this->hasRole('professor');
    }

    public function student() {
        return $this->hasOne(Student::class);
    }

    public function professor() {
        return $this->hasOne(Professor::class);
    }
  
    public function afficheRole(){
        if($this->hasRole('student')){
            echo "Etudiant";
        }
        if($this->hasRole('admin')){
            echo "Admin";
        }
        if($this->hasRole('professor')){
            echo "Professeur";
        }
    }
}
