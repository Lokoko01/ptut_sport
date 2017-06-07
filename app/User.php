<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Student;

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

    public function afficheStudentID()
    {
        if ($this->hasRole('student')) {
            return $this->Student->myId();
        }
    }

    public function displaySessions()
    {
        $studentId = Auth::user()->student->id;

        if ($studentId) {
            if (!$this->_haveSport($studentId)) {
                $wishes = DB::table('student_wishes')
                    ->join('sessions', 'student_wishes.session_id', '=', 'sessions.id')
                    ->join('sports', 'sessions.sport_id', "=", "sports.id")
                    ->join('timeSlots', 'sessions.timeSlot_id', '=', 'timeSlots.id')
                    ->join('locations', 'sessions.location_id', '=', 'locations.id')
                    ->select('sports.label', 'locations.name', 'locations.city', 'timeSlots.*')
                    ->orderBy('student_wishes.rank')
                    ->where('student_wishes.student_id', '=', $studentId)
                    ->get();

                $wishes = $wishes->all();
                $wishesHtml = "";

                foreach ($wishes as $wish) {
                    $wishesHtml .= "<tr><td>" . $wish->label . " - " . $wish->dayOfWeek . " " . $wish->startTime . ":" . $wish->endTime . " - " . $wish->name . " (" . $wish->city . ") " . "</td></tr>";
                }
                $wishesHtml .= "<tr><td><a href='student/choose_sport'>Modifier mes voeux</a></td></tr>";
                return $wishesHtml;
            } else {
                $sessions = DB::table('student_sport')
                    ->join('sessions', 'student_sport.session_id', '=', 'sessions.id')
                    ->join('sports', 'sessions.sport_id', "=", "sports.id")
                    ->join('timeSlots', 'sessions.timeSlot_id', '=', 'timeSlots.id')
                    ->join('locations', 'sessions.location_id', '=', 'locations.id')
                    ->select('sports.label', 'locations.name', 'locations.city', 'timeSlots.*')
                    ->where('student_sport.student_id', '=', $studentId)
                    ->get();

                $sessions = $sessions->all();
                $sessionsHtml = "";

                if (count($sessions) == 0) {
                    $sessionsHtml = "<tr><td><a href='student/choose_sport'> Faire une demande d'inscription pour un ou plusieurs sports</a></td></tr>";
                } else {
                    foreach ($sessions as $session) {
                        $sessionsHtml .= "<tr><td>" . $session->label . " - " . $session->dayOfWeek . " " . $session->startTime . ":" . $session->endTime . " - " . $session->name . " (" . $session->city . ") " . "</td></tr>";
                    }
                }
                return $sessionsHtml;
            }
        } else return "Erreur: impossible de récupérer les sports (problème d'authentification)";
    }


    public function displayMarks()
    {
        $studentId = Auth::user()->student->id;
        if ($studentId) {
            $marks = DB::table('student_sport')
                ->join('marks', 'marks.student_sport_id', '=', 'student_sport.id')
                ->join('sessions', 'sessions.id', '=', 'student_sport.session_id')
                ->join('sports', 'sports.id', '=', 'sessions.sport_id')
                ->select('marks.mark', 'sports.label')
                ->where('student_sport.student_id', '=', $studentId)
                ->get();


            $marks = $marks->all();
            $marksHtml = "";

            if (count($marks) == 0) {
                $marksHtml = "<tr><td>Pas de notes</td></tr>";
            } else {
                foreach ($marks as $mark) {
                    $marksHtml .= "<tr><td>" . $mark->label . " : " . $mark->mark . "</td></tr>";
                }
            }
            return $marksHtml;

        } else return "Erreur: impossible de récuperer les notes (problème d'authentification)";
    }

    public function displayMissings()
    {
        $studentId = Auth::user()->student->id;
        if ($studentId) {
            $missings = DB::table('absences')
                ->join('student_sport', 'student_sport.id', '=', 'absences.student_sport_id')
                ->join('sessions', 'sessions.id', '=', 'student_sport.session_id')
                ->join('sports', 'sports.id', '=', 'sessions.sport_id')
                ->select('sports.label', 'absences.date', 'absences.isJustified')
                ->where('student_sport.student_id', "=", $studentId)
                ->get();

            $missings = $missings->all();
            $missingsHtml = "";

            if (count($missings) == 0) {
                $missingsHtml = "<tr><td>Pas d'absences</td></tr>";
            } else {
                foreach ($missings as $missing) {
                    //todo: ajouter une coloration si justifiée ou non
                    if ($missing->isJustified == 0) {
                        $missingsHtml .= "<tr><td style='color: #ff0000'>" . $missing->label . " (" . $missing->date . ") : Non justifiée" . "</td></tr>";
                    } else if ($missing->isJustified == 1) {
                        $missingsHtml .= "<tr><td>" . $missing->label . " (" . $missing->date . ") : Justifiée" . "</td></tr>";
                    } else $missingsHtml .= "Erreur sur cette absence : données invalides";
                }
            }
            return $missingsHtml;
        } else return "Erreur: impossible de récupérer les notes (problème d'authentification)";
    }

    public function displaySportOrWish()
    {
        $studentId = Auth::user()->student->id;

        if ($this->_haveSport($studentId)) {
            return "Mes sports";
        } else return "Mes voeux";
    }

    private function _haveWishes($studentId)
    {
        $wishes = DB::table('student_wishes')
            ->select('*')
            ->where('student_id', '=', $studentId)
            ->get();

        if (empty($wishes->all())) {
            return false;
        } else return true;
    }

    private function _haveSport($studentId){
        $sports = DB::table('student_sport')
            ->select('*')
            ->where('student_id', '=', $studentId)
            ->get();

        if (empty($sports->all())) {
            return false;
        } else return true;
    }
}
