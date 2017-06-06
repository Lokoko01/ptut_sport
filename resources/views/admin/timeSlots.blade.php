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
                    @if(session()->has('timeSlotAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('timeSlotAlreadyExist') }}
                        </div>
                    @endif
                    <div class="panel-heading">Liste des créneaux - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('timeSlotRegister')) !!}
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
                            @foreach($timeSlots as $timeSlot)
                                <tr>
                                    <td>
                                        {{$timeSlot->postCode}}
                                    </td>
                                    <td>
                                        {{$timeSlot->streetName}}
                                    </td>
                                    <td>
                                        {{$timeSlot->streetNumber}}
                                    </td>
                                    <td>
                                        {{$timeSlot->city}}
                                    </td>
                                    <td>
                                        {{$timeSlot->name}}
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                data-target="#{{$timeSlot->id}}Modal">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <div class="modal fade" id="{{$timeSlot->id}}Modal"
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
                                                            {{$timeSlot->streetNumber . ' ' . $timeSlot->streetName . ', ' . $timeSlot->postCode . ' ' . $timeSlot->city}}
                                                        </h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('updateLocation')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::text('Code Postal', 'postCodeNew')->attribute('type', 'number')->value($timeSlot->postCode) !!}
                                                        {!! BootForm::hidden('postCodeOld')->value($timeSlot->postCode) !!}
                                                        {!! BootForm::text('Nom de la rue', 'streetNameNew')->value($timeSlot->streetName) !!}
                                                        {!! BootForm::hidden('streetNameOld')->value($timeSlot->streetName) !!}
                                                        {!! BootForm::text('Numéro de la rue', 'streetNumberNew')->attribute('type', 'number')->value($timeSlot->streetNumber) !!}
                                                        {!! BootForm::hidden('streetNumberOld')->value($timeSlot->streetNumber) !!}
                                                        {!! BootForm::text('Ville', 'cityNew')->value($timeSlot->city) !!}
                                                        {!! BootForm::hidden('cityOld')->value($timeSlot->city) !!}
                                                        {!! BootForm::text('Salle', 'nameNew')->value($timeSlot->name) !!}
                                                        {!! BootForm::hidden('nameOld')->value($timeSlot->name) !!}
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
                                                data-target="#{{$timeSlot->id}}ModalDelete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <div class="modal fade" id="{{$timeSlot->id}}ModalDelete"
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
                                                            {{$timeSlot->streetNumber . ' ' . $timeSlot->streetName . ', ' . $timeSlot->postCode . ' ' . $timeSlot->city}}
                                                        </h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('deleteLocation')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::hidden('postCode')->value($timeSlot->postCode) !!}
                                                        {!! BootForm::hidden('streetName')->value($timeSlot->streetName) !!}
                                                        {!! BootForm::hidden('streetNumber')->value($timeSlot->streetNumber) !!}
                                                        {!! BootForm::hidden('city')->value($timeSlot->city) !!}
                                                        {!! BootForm::hidden('name')->value($timeSlot->name) !!}
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
                            {!! $timeSlots->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
