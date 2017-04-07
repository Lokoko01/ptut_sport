<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sport;
use Illuminate\Support\Facades\DB;

class SportController extends Controller
{
    public function addSport(Request $request)
    {
        $data = [
            'sport' => $request->input('sport')
        ];

        $this->validate($request, [
            'sport' => 'required|max:255'
        ]);

        if ($this->isSportAlreadyExist($data['sport'])) {
            return redirect('/admin/sport')->with('sportAlreadyExist', 'Le sport ' . $data['sport'] . ' est déjà dans la base de donnée');

        } else {
            Sport::create([
                'label' => $data['sport']
            ]);

            return redirect('/admin/sport')->with('message', $data['sport'] . ' ajouté');
        }

    }

    public function updateSport(Request $request)
    {
        $data = [
            'sportOld' => $request->input('sportOld'),
            'sportNew' => $request->input('sportNew')
        ];

        $this->validate($request, [
            'sportNew' => 'required|max:255',
            'sportOld' => 'required|max:255'
        ]);
        DB::table('sports')
            ->where('label', $data['sportOld'])
            ->update(['label' => $data['sportNew']]);
        return redirect('/admin/sport')->with('message', $data['sportOld'] . ' mise à jour en ' . $data['sportNew']);
    }

    public function deleteSport(Request $request)
    {
        $data = ['sport' => $request->input('sport')];

        $this->validate($request, ['sport' => 'required|max:255']);

        if($this->isSportCantDelete($data['sport'])) {
            DB::table('sports')->where('label', $data['sport'])->delete();
            return redirect('/admin/sport')->with('message', $data['sport'] . ' a été supprimé');
        }else{
            return redirect('/admin/sport')->with('message', $data['sport'] . ' est utilisé dans un créneau, il ne peut donc pas être supprimé.');
        }
    }

    private function isSportAlreadyExist($sportName)
    {
        $sport = DB::table('sports')->where('label', $sportName)->get();
        if (!empty($sport->all())) {
            return true;
        } else return false;
    }

    private function isSportCantDelete($sportName){
        $sportId = DB::table('sports')->where('label', $sportName)->value('id');
        $sport = DB::table('sessions')->where('sport_id', $sportId)->get();
        if (empty($sport->all())) {
            return true;
        } else return false;
    }
}
