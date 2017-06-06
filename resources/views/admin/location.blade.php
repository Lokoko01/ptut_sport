@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if(session()->has('locationAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('locationAlreadyExist') }}
                        </div>
                    @endif
                    <div class="panel-heading">Liste des lieux - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('locationRegister')) !!}
                        {!! BootForm::text('Code Postal', 'postCode') !!}
                        {!! BootForm::text('Nom de la rue', 'streetName') !!}
                        {!! BootForm::text('Numéro de la rue', 'streetNumber') !!}
                        {!! BootForm::text('Ville', 'city') !!}
                        {!! BootForm::text('Salle', 'name') !!}
                        {!! BootForm::submit("Ajouter le lieu")->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    Code Postal
                                </th>
                                <th>
                                    Nom de la rue
                                </th>
                                <th>
                                    Numéro de la rue
                                </th>
                                <th>
                                    Ville
                                </th>
                                <th>
                                    Salle
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($locations as $location)
                                <tr>
                                    <td>
                                        {{$location->postCode}}
                                    </td>
                                    <td>
                                        {{$location->streetName}}
                                    </td>
                                    <td>
                                        {{$location->streetNumber}}
                                    </td>
                                    <td>
                                        {{$location->city}}
                                    </td>
                                    <td>
                                        {{$location->name}}
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                data-target="#{{$location->id}}Modal">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <div class="modal fade" id="{{$location->id}}Modal"
                                             tabindex="-1" role="dialog"
                                             aria-labelledby="favoritesModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="favoritesModalLabel">
                                                            {{$location->streetNumber . ' ' . $location->streetName . ', ' . $location->postCode . ' ' . $location->city}}
                                                        </h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('updateLocation')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::text('Code Postal', 'postCodeNew')->attribute('type', 'number')->value($location->postCode) !!}
                                                        {!! BootForm::hidden('postCodeOld')->value($location->postCode) !!}
                                                        {!! BootForm::text('Nom de la rue', 'streetNameNew')->value($location->streetName) !!}
                                                        {!! BootForm::hidden('streetNameOld')->value($location->streetName) !!}
                                                        {!! BootForm::text('Numéro de la rue', 'streetNumberNew')->attribute('type', 'number')->value($location->streetNumber) !!}
                                                        {!! BootForm::hidden('streetNumberOld')->value($location->streetNumber) !!}
                                                        {!! BootForm::text('Ville', 'cityNew')->value($location->city) !!}
                                                        {!! BootForm::hidden('cityOld')->value($location->city) !!}
                                                        {!! BootForm::text('Salle', 'nameNew')->value($location->name) !!}
                                                        {!! BootForm::hidden('nameOld')->value($location->name) !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! BootForm::submit("Modifier")->class('btn btn-primary') !!}
                                                    </div>
                                                    {!! BootForm::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-danger"
                                                data-toggle="modal"
                                                data-target="#{{$location->id}}ModalDelete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <div class="modal fade" id="{{$location->id}}ModalDelete"
                                             tabindex="-1" role="dialog"
                                             aria-labelledby="favoritesModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="favoritesModalLabel">
                                                            {{$location->streetNumber . ' ' . $location->streetName . ', ' . $location->postCode . ' ' . $location->city}}
                                                        </h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('deleteLocation')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::hidden('postCode')->value($location->postCode) !!}
                                                        {!! BootForm::hidden('streetName')->value($location->streetName) !!}
                                                        {!! BootForm::hidden('streetNumber')->value($location->streetNumber) !!}
                                                        {!! BootForm::hidden('city')->value($location->city) !!}
                                                        {!! BootForm::hidden('name')->value($location->name) !!}
                                                        <p>Voulez-vous vraiment supprimer ce lieu ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! BootForm::submit("Supprimer")->class('btn btn-danger') !!}
                                                    </div>
                                                    {!! BootForm::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $locations->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
