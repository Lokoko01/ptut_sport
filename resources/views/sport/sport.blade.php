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
                    <div class="panel-heading">Accueil - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('sportRegister')) !!}
                        {!! BootForm::text('Sport', 'sport') !!}
                        {!! BootForm::submit("Ajouter le sport")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Sport</th>
                                <th>Modifer</th>
                                <th>Supprimer</th>
                            </tr>
                            @foreach($sports as $sport)

                                <tr>
                                    <td>{{ $sport }}</td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                data-target="#{{$sport}}Modal">
                                            Modifier
                                        </button>
                                        <div class="modal fade" id="{{$sport}}Modal"
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
                                                            id="favoritesModalLabel">{{$sport}}</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('updateSport')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::text('Sport', 'sportNew')->value($sport) !!}
                                                        {!! BootForm::hidden('sportOld')->value($sport) !!}
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
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                data-target="#{{$sport}}ModalDelete">
                                            Supprimer
                                        </button>
                                        <div class="modal fade" id="{{$sport}}ModalDelete"
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
                                                            id="favoritesModalLabel">{{$sport}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! BootForm::openHorizontal($columnSizes)->action(route('deleteSport')) !!}
                                                        {!! BootForm::hidden('sport')->value($sport) !!}
                                                        {!! BootForm::submit("Supprimer")->class('btn btn-primary') !!}
                                                        {!! BootForm::close() !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
