<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function isAdmin()
    {
        return $this->hasrole('admin');
    }

    public function isProfessor()
    {
        return $this->hasRole('professor');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function professor()
    {
        return $this->hasOne(Professor::class);
    }

    public function afficheRole()
    {
        if ($this->hasRole('student')) {
            echo "Etudiant";
        }
        if ($this->hasRole('admin')) {
            echo "Admin";
        }
        if ($this->hasRole('professor')) {
            echo "Professeur";
        }
    }

    public function displaySessions()
    {
        if ($this->isStudent()) {
            $userId = Auth::id();
            $studentIdField = DB::select('select id from students where user_id = :userId', ['userId' => $userId]);

            if (count($studentIdField) == 1) {
                $studentId = $studentIdField[0]->id;
                if (!empty($studentId)) {
                    $sessions = DB::table('student_sport')
                        ->join('sessions', 'student_sport.session_id', '=', 'sessions.id')
                        ->select('sessions.timeSlot_id', 'sessions.sport_id', 'sessions.location_id')
                        ->where('student_sport.student_id', '=', $studentId)
                        ->get();

                    $sessionsReady = array();
                    $sessions = $sessions->all();

                    for ($i = 0; $i < count($sessions); $i++) {
                        //TODO: optimiser cette requete en une seule avec des jointures
                        $sportName = DB::select('select label from sports where id = :sportId', ['sportId' => $sessions[$i]->sport_id])[0]->label;
                        $timeSlot = DB::select("select CONCAT(dayOfWeek, ' ',startTime, ':',endTime) as time from timeSlots where id = :timeSlotId", ['timeSlotId' => $sessions[$i]->timeSlot_id])[0]->time;
                        $place = DB::select("select concat(name,' (', city, ')') as place from locations where id = :locationId", ['locationId' => $sessions[$i]->location_id])[0]->place;

                        if (!empty($sportName) && !empty($timeSlot) && !empty($place)) {
                            $sessionsReady[$i] = $sportName . " - " . $timeSlot . " - " . $place;
                        } else {
                            return "Erreur : impossible de récupérer les sports";
                        }
                    }

                    $sessionsHtml = "";
                    foreach ($sessionsReady as $session) {
                        $sessionsHtml = $sessionsHtml . "<tr><td>" . $session . "</td></tr>";
                    }

                    return $sessionsHtml;
                } else return "Erreur: impossible de récupérer les sports (problème d'authentification)";
            } else return "Erreur: impossible de récupérer les sports (problème d'authentification)";
        } else return "Erreur: impossible de récupérer les notes (problème d'authentification)";
    }


    public function displayMarks()
    {
        if ($this->isStudent()) {
            $userId = Auth::id();
            $studentIdField = DB::select('select id from students where user_id = :userId', ['userId' => $userId]);

            $studentId = $studentIdField[0]->id;
            if (!empty($studentId)) {
                if (count($studentIdField) == 1) {
                    $marks = DB::table('marks')
                        ->select('session_id', 'mark')
                        ->where('student_id', '=', $studentId)
                        ->get();

                    $marks = $marks->all();
                    $marksReady = array();

                    for ($i = 0; $i < count($marks); $i++) {
                        $sportName = DB::table('sports')
                            ->join('sessions', 'sessions.sport_id', '=', 'sports.id')
                            ->join('marks', 'marks.session_id', '=', 'sessions.id')
                            ->select('sports.label')
                            ->where('marks.session_id', '=', $marks[$i]->session_id)
                            ->get();

                        $sportName = $sportName->all()[0]->label;

                        if (!empty($sportName) && !empty($marks)) {
                            $marksReady[$i] = $sportName . ' : ' . $marks[$i]->mark;
                        } else return "Erreur: Impossible de récupérer les notes";
                    }

                    $marksHtml = "";

                    foreach ($marksReady as $mark) {
                        $marksHtml = $marksHtml . "<tr><td>" . $mark . "</td></tr>";
                    }
                    return $marksHtml;

                } else return "Erreur: impossible de récuperer les notes (problème d'authentification)";
            } else return "Erreur: impossible de récuperer les notes (problème d'authentification)";
        } else return "Erreur: impossible de récupérer les notes (problème d'authentification)";
    }

    public function displayMissings()
    {
        if ($this->isStudent()) {
            $userId = Auth::id();
            $studentIdField = DB::select('select id from students where user_id = :userId', ['userId' => $userId]);

            $studentId = $studentIdField[0]->id;
            if (!empty($studentId)) {
                if (count($studentIdField) == 1) {
                    $missings = DB::table('absences')
                        ->join('student_sports', 'student_sport.id', '=', 'absences.studentSport_id')
                        ->join('sessions', 'sessions.id', '=', 'student_sport.session_id')
                        ->join('sports', 'sports.id', '=', 'sessions.sport_id')
                        ->select('sports.label', 'absences.date')
                        ->get();

                    $missings = $missings->all();
                    $missingsReady = array();

                    for($i = 0; $i<count($missings); $i++){
                        //todo: continuer
                    }
                }
            }
        }
    }
}
