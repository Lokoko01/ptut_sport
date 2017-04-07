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
        dump($data);

        $this->validate($request, [
            'sportNew' => 'required|max:255',
            'sportOld' => 'required|max:255'
        ]);
        DB::table('sports')
            ->where('label', $data['sportOld'])
            ->update(['label' => $data['sportNew']]);
        return redirect('/admin/sport')->with('message', $data['sportOld'] . 'mise à jour en' . $data['sportNew']);
    }

    private function isSportAlreadyExist($sportName)
    {
        $sport = DB::table('sports')->where('label', $sportName)->get();
        if (!empty($sport->all())) {
            return true;
        } else return false;
    }
}
