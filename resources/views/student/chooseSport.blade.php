@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Accueil - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('addWishesAsStudent')) !!}
                        {!! BootForm::hidden('studentId')->value(Auth::user()->afficheStudentID()) !!}
                        <label for="voeu1">Voeu 1 :</label><br>
                        <select name="voeu1">
                            <option value="0" selected="selected">Sélectionnez votre sport</option>
                            @foreach($creneaux as $creneau)
                                <option value="{{$creneau->id}}">{{$creneau->label}} : {{$creneau->dayOfWeek}}
                                    de {{$creneau->startTime}} à {{$creneau->endTime}} - {{$creneau->name}}</option>
                            @endforeach
                        </select><br>
                        <label for="voeu2">Voeu 2 :</label><br>
                        <select name="voeu2">
                            <option value="0" selected="selected">Sélectionnez votre sport</option>
                            @foreach($creneaux as $creneau)
                                <option value="{{$creneau->id}}">{{$creneau->label}} : {{$creneau->dayOfWeek}}
                                    de {{$creneau->startTime}} à {{$creneau->endTime}} - {{$creneau->name}}</option>
                            @endforeach
                        </select><br>
                        <label for="voeu3">Voeu 3 :</label><br>
                        <select name="voeu3">
                            <option value="0" selected="selected">Sélectionnez votre sport</option>
                            @foreach($creneaux as $creneau)
                                <option value="{{$creneau->id}}">{{$creneau->label}} : {{$creneau->dayOfWeek}}
                                    de {{$creneau->startTime}} à {{$creneau->endTime}} - {{$creneau->name}}</option>
                            @endforeach
                        </select>
                        {!! BootForm::submit("Ajouter le voeu")->class('btn btn-success') !!}
                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
@endsection