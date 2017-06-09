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
                    <div class="panel-heading">Envoi de message - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'sm' => [5, 4],
                            'md' => [5, 4],
                            'lg' => [5, 4]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('addMessage')) !!}
                        <h4>Choisir les destinataires</h4>
                        <select name="select_sessions">
                            <option value="0">Par séance</option>
                            @foreach($sessions as $session)
                                <option value="{{$session->id}}">{{$session->label}}
                                    - {{$session->dayOfWeek}} {{$session->startTime}} : {{$session->endTime}}
                                    - {{$session->name}} ({{$session->city}})
                                </option>
                            @endforeach
                        </select>
                        <br>
                        et/ou
                        <br>
                        <select name="select_user">
                            <option value="0">Par type utilisateur</option>
                            @foreach($typeOfUser as $type)
                                <option value="{{$type->id}}">{{$type->display_name}}</option>
                            @endforeach
                            <option value="all">Tout les utilisateurs</option>
                        </select>
                        <br>
                        <h4>Message</h4>
                        <br>
                        <textarea name="message" rows="4" cols="50" maxlength="250" style="width: 100%">
                            </textarea>
                        {!! BootForm::submit("Envoyer le message")->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                        <table class="main-table">
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <td>
                                        {{ Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ $message->message }}
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-danger"
                                                data-toggle="modal"
                                                data-target="#{{$message->id}}ModalDelete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <div class="modal fade" id="{{$message->id}}ModalDelete"
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
                                                            id="favoritesModalLabel">{{$message->message}}</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('deleteMessage')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::hidden('messageId')->value($message->id) !!}
                                                        <p>Voulez-vous vraiment supprimer ce message ?</p>
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
                            {!! $messages->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
