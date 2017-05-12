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
                    @if(session()->has('ufrAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('ufrAlreadyExist') }}
                        </div>
                    @endif
                    <div class="panel-heading">Liste des UFR - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('ufrRegister')) !!}
                        {!! BootForm::text('Code', 'code') !!}
                        {!! BootForm::text('Label', 'label') !!}
                        {!! BootForm::submit("Ajouter l'UFR")->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    Code
                                </th>
                                <th>
                                    Label
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($ufrs as $ufr)
                                <tr>
                                    <td>
                                        {{$ufr->code}}
                                    </td>
                                    <td>
                                        {{$ufr->label}}
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                data-target="#{{$ufr->label}}Modal">
                                            Modifier
                                        </button>
                                        <div class="modal fade" id="{{$ufr->label}}Modal"
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
                                                            id="favoritesModalLabel">{{$ufr->label}}</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('updateUfr')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::text('Label', 'labelNew')->value($ufr->label) !!}
                                                        {!! BootForm::text('Code', 'codeNew')->value($ufr->code) !!}
                                                        {!! BootForm::hidden('idUfr')->value($ufr->id) !!}
                                                        {!! BootForm::submit("Modifier")->class('btn btn-primary') !!}
                                                    </div>
                                                    <div class="modal-footer">
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
                                                data-target="#{{$ufr->label}}ModalDelete">
                                            Supprimer
                                        </button>
                                        <div class="modal fade" id="{{$ufr->label}}ModalDelete"
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
                                                            id="favoritesModalLabel">{{$ufr->label}}</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('deleteUfr')) !!}
                                                    <div class="modal-body">
                                                        <p>Voulez-vous vraiment supprimé cette UFR ?</p>
                                                        {!! BootForm::hidden('ufrId')->value($ufr->id) !!}
                                                        {!! BootForm::hidden('ufrName')->value($ufr->label) !!}
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
                            {!! $ufrs->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
