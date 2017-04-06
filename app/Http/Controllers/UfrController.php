<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ufr;
class UfrController extends Controller

{
    public function addUfr(Request $request)
    {
        $data = [
            'code' => $request->input('code'),
            'label' => $request->input('label')
        ];

        $this->validate($request, [
            'code' => 'required|max:255',
            'label' => 'required|max:255',
        ]);

        if($this->isUfrAlreadyExist($data['label'])){
            return redirect('/admin/addufr')->with('ufrAlreadyExist', 'UFR '.$data['label'].' est déjà dans la base de donnée');

        } else {
            Ufr::create([
                'code' => $data['code'],
                'label' => $data['label']
            ]);

            return redirect('/admin/addufr')->with('message', $data['label'].' ajouté');
        }

    }

    private function isUfrAlreadyExist($ufrName){
        $ufr = DB::table('ufr')->where('label', $ufrName)->get();
        if(!empty($ufr->all())){
            return true;
        }else return false;
    }
}

