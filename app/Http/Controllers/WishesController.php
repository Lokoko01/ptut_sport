<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishesController extends Controller
{
   public function addWishesAsStudent(Request $request){
       echo var_dump($_POST);
       $data = [
           'voeu1' => $request->input('voeu1'),
           'voeu2' => $request->input('voeu2'),
           'voeu3' => $request->input('voeu3'),
           'studentId' => $request->input('studentId')
       ];
        if($data['voeu1'] == '0'){

        }else{
            DB::table('student_wishes')->insert([
                ['student_id' => $data['studentId'], 'session_id' => $data['voeu1']]
            ]);
        }
   }

}
