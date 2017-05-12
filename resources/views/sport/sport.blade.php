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
                    @if(session()->has('sportAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('sportAlreadyExist') }}
                        </div>
                    @endif
                    <div class="panel-heading">Liste des sports - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('sportRegister')) !!}
                        {!! BootForm::text('Sport', 'sport') !!}
                        {!! BootForm::submit("Ajouter le sport")->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    Sport
                                </th>
                                <th>
                                    Professeur
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($sports as $sport)
                                <tr>
                                    <td>
                                        {{$sport->label}}
                                    </td>
                                    <td>
                                        {{$sport->lastname}}
                                        {{$sport->firstname}}
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                data-target="#{{$sport->id}}Modal">
                                            Modifier
                                        </button>
                                        <div class="modal fade" id="{{$sport->id}}Modal"
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
                                                            id="favoritesModalLabel">{{$sport->label}}</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('updateSport')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::text('Sport', 'sportNew')->value($sport->label) !!}
                                                        {!! BootForm::hidden('sportOld')->value($sport->label) !!}
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
                                                data-target="#{{$sport->label}}ModalDelete">
                                            Supprimer
                                        </button>
                                        <div class="modal fade" id="{{$sport->label}}ModalDelete"
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
                                                            id="favoritesModalLabel">{{$sport->label}}</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('deleteSport')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::hidden('sport')->value($sport->label) !!}
                                                        <p>Voulez-vous vraiment supprimer ce sport ?</p>
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
                                {!! $sports->render() !!}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
