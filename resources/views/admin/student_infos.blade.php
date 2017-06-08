@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edition de l'étudiant
                        - {{$userInfos->firstname}} {{$userInfos->lastname}}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'sm' => [5, 4],
                            'md' => [5, 4],
                            'lg' => [5, 4]
                        ];
                        ?>
                        <table class="table">
                            <caption>Absences</caption>
                            <tr>
                                <th>Date</th>
                                <th>Sport</th>
                                <th>Justifiée</th>
                            </tr>
                            @isset($absences)
                            @foreach($absences as $absence)
                                <tr>
                                    <td>{{$absence->date}}</td>
                                    <td>{{$absence->label}}</td>
                                    @if($absence->isJustified)
                                        {{--<td><img src="/public/images/icons8-Checkmark-48.png"></td>--}}
                                        <td>Oui</td>
                                    @else
                                        {{--<td><img src="/public/images/icons8-Delete-48.png"></td>--}}
                                        <td>Non</td>
                                    @endif
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                style="background-color: #f39c12; border-color: #d35400"
                                                data-target="#{{$absence->id}}AbsenceModal">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <div class="modal fade" id="{{$absence->id}}AbsenceModal"
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
                                                            id="favoritesModalLabel">Modifier l'absence</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('edit_absence')) !!}
                                                    {!! BootForm::hidden('absence_id')->value($absence->id) !!}
                                                    @if($absence->isJustified)
                                                        {!! BootForm::checkbox('Justifiée', 'isJustified')->checked()!!}
                                                    @else
                                                        {!! BootForm::checkbox('Justifiée', 'isJustified')!!}
                                                    @endif
                                                    {!! BootForm::submit("Valider")->class('btn btn-primary') !!}
                                                    {!! BootForm::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @endisset
                        </table>
                        <table class="table">
                            <caption>Notes</caption>
                            <tr>
                                <th>Note</th>
                                <th>Sport</th>
                                <th>Commentaire</th>
                            </tr>
                            @isset($marks)
                            @foreach($marks as $mark)
                                <tr>
                                    <td>{{$mark->mark}}</td>
                                    <td>{{$mark->label}}</td>
                                    <td>{{$mark->comment}}</td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                style="background-color: #f39c12; border-color: #d35400"
                                                data-target="#{{$mark->id}}MarkModal">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <div class="modal fade" id="{{$mark->id}}MarkModal"
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
                                                            id="favoritesModalLabel">Modifier la note</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('edit_mark')) !!}
                                                    {!! BootForm::hidden('mark_id')->value($mark->id) !!}
                                                    {!! BootForm::text('Note', 'mark')->value($mark->mark)->type('number')!!}
                                                    {!! BootForm::textarea('Commentaire', 'comment')->value($mark->comment) !!}
                                                    {!! BootForm::submit("Valider")->class('btn btn-primary') !!}
                                                    {!! BootForm::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @endisset
                        </table>
                        <table class="table">
                            <caption>Sports</caption>
                            <tr>
                                <th>Sport</th>
                                <th>Séance</th>
                                <th>Lieu</th>
                                <th>Professeur</th>
                            </tr>
                            @isset($sessions)
                            @foreach($sessions as $session)
                                <tr>
                                    <td>{{$session->label}}</td>
                                    <td>{{$session->timeSlot}}</td>
                                    <td>{{$session->location}}</td>
                                    <td>{{$session->professor}}</td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary button-delete"
                                                data-toggle="modal"
                                                data-target="#{{$session->id}}SessionModal">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                        <div class="modal fade" id="{{$session->id}}SessionModal"
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
                                                            id="favoritesModalLabel">Modifier la note</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('delete_session')) !!}
                                                    {!! BootForm::hidden('sessionId')->value($session->id) !!}
                                                    {!! BootForm::hidden('studentId')->value($userInfos->id) !!}
                                                    {!! BootForm::label('Voulez-vraiment supprimer cet étudiant de ce sport ?') !!}
                                                    {!! BootForm::submit("Supprimer")->class('btn btn-primary button-delete') !!}
                                                    {!! BootForm::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @endisset
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
