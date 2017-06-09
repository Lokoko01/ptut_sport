@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(session()->has('succeed_message_session'))
                        <div class="alert alert-success">
                            {{ session()->get('succeed_message_session') }}
                        </div>
                    @endif
                    @if(session()->has('error_message_session'))
                        <div class="alert alert-warning">
                            {{ session()->get('error_message_session') }}
                        </div>
                     @endif
                    <div class="panel-heading">Ajout d'une séance</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('register_session')) !!}
                        {!! BootForm::select('Sport', 'sport')->options($sports) !!}
                        {!! BootForm::select('Créneau', 'timeSlot')->options($timeSlots) !!}
                        {!! BootForm::select('Professeur', 'professor')->options($professors) !!}
                        {!! BootForm::select('Lieu', 'location')->options($locations) !!}
                        {!! BootForm::text('Nombre de places max', 'max_seat')->attribute('type', 'number')->max('50') !!}
                        {!! BootForm::submit("Ajouter")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
