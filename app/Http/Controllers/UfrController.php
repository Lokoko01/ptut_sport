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
            return redirect('/admin/ufr')->with('ufrAlreadyExist', 'UFR '.$data['label'].' est déjà dans la base de donnée');

        } else {
            Ufr::create([
                'code' => $data['code'],
                'label' => $data['label']
            ]);

            return redirect('/admin/ufr')->with('message', $data['label'].' ajouté');
        }

    }

    public function updateUfr(Request $request)
    {
        $data = [
            'labelNew' => $request->input('labelNew'),
            'codeNew' => $request->input('codeNew'),
            'idUfr'   => $request->input('idUfr')
        ];

        $this->validate($request, [
            'labelNew' => 'required|max:255',
            'codeNew' => 'required|max:255'
        ]);
        DB::table('ufr')
            ->where('id', $data['idUfr'])
            ->update(['label' => $data['labelNew'], 'code' => $data['codeNew']]);
        return redirect('/admin/ufr')->with('message', $data['codeNew'] . ' mise à jour');
    }

    private function isUfrAlreadyExist($ufrName){
        $ufr = DB::table('ufr')->where('label', $ufrName)->get();
        if(!empty($ufr->all())){
            return true;
        }else return false;
    }


    public function deleteUfr(Request $request)
    {
        $data = [
            'ufrId' => $request->input('ufrId'),
            'ufrName' => $request->input('ufrName'),
            ];
        $this->validate($request, ['ufrId' => 'required|max:255']);

        if($this->isUfrAlreadyExist($data['ufrId'])){
            DB::table('ufr')->where('id', $data['ufrId'])->delete();
            return redirect('/admin/ufr')->with('message', $data['ufrName'] . ' a été supprimé');
        }else{
            return redirect('/admin/ufr')->with('message', $data['ufrName'] . ' ne peut être supprimé, car au moins un étudiant est inscrits avec cette UFR');
        }

    }
    private function isUfrCantDelete($ufrId){
        $students = DB::table('students')->where('ufr_id', $ufrId)->get();
        if (empty($students->all())) {
            return true;
        } else return false;
    }
}

