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
                        {!! BootForm::text('Jour de la semaine', 'dayOfWeek') !!}
                        {!! BootForm::text('Heure de début', 'startTime') !!}
                        {!! BootForm::text('Heure de fin', 'endTime') !!}
                        {!! BootForm::submit("Ajouter le créneau")->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    Jour de la semaine
                                </th>
                                <th>
                                    Heure de début
                                </th>
                                <th>
                                    Heure de fin
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($timeSlots as $timeSlot)
                                <tr>
                                    <td>
                                        {{$timeSlot->dayOfWeek}}
                                    </td>
                                    <td>
                                        {{$timeSlot->startTime}}
                                    </td>
                                    <td>
                                        {{$timeSlot->endTime}}
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
                                                            {{$timeSlot->dayOfWeek . ' ' . $timeSlot->startTime . '-' . $timeSlot->endTime}}
                                                        </h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('updateTimeSlot')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::text('Jour de la semaine', 'dayOfWeekNew')->value($timeSlot->dayOfWeek) !!}
                                                        {!! BootForm::hidden('dayOfWeekOld')->value($timeSlot->dayOfWeek) !!}
                                                        {!! BootForm::text('Heure de début', 'startTimeNew')->value($timeSlot->startTime) !!}
                                                        {!! BootForm::hidden('startTimeOld')->value($timeSlot->startTime) !!}
                                                        {!! BootForm::text('Heure de fin', 'endTimeNew')->value($timeSlot->endTime) !!}
                                                        {!! BootForm::hidden('endTimeOld')->value($timeSlot->endTime) !!}
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
                                                            {{$timeSlot->dayOfWeek . ' ' . $timeSlot->startTime . '-' . $timeSlot->endTime}}
                                                        </h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('deleteTimeSlot')) !!}
                                                    <div class="modal-body">
                                                        {!! BootForm::hidden('dayOfWeek')->value($timeSlot->dayOfWeek) !!}
                                                        {!! BootForm::hidden('startTime')->value($timeSlot->startTime) !!}
                                                        {!! BootForm::hidden('endTime')->value($timeSlot->endTime) !!}
                                                        <p>Voulez-vous vraiment supprimer ce créneau ?</p>
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
