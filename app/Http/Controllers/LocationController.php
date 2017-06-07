<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function addLocation(Request $request)
    {
        $data = $request->only(
            [
                'postCode', 'streetName', 'streetNumber', 'city', 'name'
            ]);

        $this->validate($request, [
            'postCode' => 'required|max:255',
            'streetName' => 'required|max:255',
            'streetNumber' => 'required|max:255',
            'city' => 'required|max:255',
            'name' => 'required|max:255'
        ]);

        if ($this->isLocationAlreadyExist($data['postCode'], $data['streetName'], $data['streetNumber'], $data['city'], $data['name'])) {
            return redirect('/admin/locations')
                ->with('locationAlreadyExist',
                    'Le lieu au' . $data['streetNumber'] . ' ' . $data['streetName'] . ' est déjà dans la base de données.');

        } else {
            Location::create([
                'postCode' => $data['postCode'],
                'streetName' => $data['streetName'],
                'streetNumber' => $data['streetNumber'],
                'city' => $data['city'],
                'name' => $data['name']
            ]);

            return redirect('/admin/locations')->with('message', 'Lieu ajouté.');
        }

    }

    private function isLocationAlreadyExist($postCode, $streetName, $streetNumber, $city, $name)
    {
        $location = DB::table('locations')
            ->where([
                ['postCode', $postCode],
                ['streetName', $streetName],
                ['streetNumber', $streetNumber],
                ['city', $city],
                ['name', $name]
            ])->get();

        if (!empty($location->all())) {
            return true;
        } else {
            return false;
        }
    }

    public function updateLocation(Request $request)
    {
        $data = $request->only(
            [
                'postCodeOld', 'postCodeNew',
                'streetNameOld', 'streetNameNew',
                'streetNumberOld', 'streetNumberNew',
                'cityOld', 'cityNew',
                'nameOld', 'nameNew'
            ]);

        $this->validate($request, [
            'postCodeNew' => 'required|max:255',
            'streetNameNew' => 'required|max:255',
            'streetNumberNew' => 'required|max:255',
            'cityNew' => 'required|max:255',
            'nameNew' => 'required|max:255'
        ]);

        DB::table('locations')
            ->where([
                ['postCode', $data['postCodeOld']],
                ['streetName', $data['streetNameOld']],
                ['streetNumber', $data['streetNumberOld']],
                ['city', $data['cityOld']],
                ['name', $data['nameOld']]
            ])
            ->update(
                [
                    'postCode' => $data['postCodeNew'],
                    'streetName' => $data['streetNameNew'],
                    'streetNumber' => $data['streetNumberNew'],
                    'city' => $data['cityNew'],
                    'name' => $data['nameNew']
                ]
            );

        return redirect('/admin/locations')->with('message', 'Lieu mis à jour.');
    }

    public function deleteLocation(Request $request)
    {
        $data = $request->only(
            [
                'postCode', 'streetName', 'streetNumber', 'city', 'name'
            ]);

        if ($this->isLocationCantDelete($data['postCode'], $data['streetName'], $data['streetNumber'], $data['city'], $data['name'])) {
            DB::table('locations')->where([
                ['postCode', $data['postCode']],
                ['streetName', $data['streetName']],
                ['streetNumber', $data['streetNumber']],
                ['city', $data['city']],
                ['name', $data['name']]
            ])->delete();
            return redirect('/admin/locations')->with('message', 'Le lieu a été supprimé.');
        } else {
            return redirect('/admin/locations')->with('message', 'Ce lieu est utilisé dans un créneau, il ne peut donc pas être supprimé.');
        }
    }

    private function isLocationCantDelete($postCode, $streetName, $streetNumber, $city, $name)
    {
        $locationId = DB::table('locations')->where([
            ['postCode', $postCode],
            ['streetName', $streetName],
            ['streetNumber', $streetNumber],
            ['city', $city],
            ['name', $name]
        ])->value('id');

        $location = DB::table('sessions')->where('location_id', $locationId)->get();

        if (empty($location->all())) {
            return true;
        } else {
            return false;
        }
    }
}
