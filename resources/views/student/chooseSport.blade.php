@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(session()->has('message_voeux_identiques'))
                        <div class="alert alert-warning">
                            {{ session()->get('message_voeux_identiques') }}
                        </div>
                    @endif
                    <div class="panel-heading">Accueil - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('addWishesToStudent')) !!}
                        {!! BootForm::hidden('studentId')->value(Auth::user()->afficheStudentID()) !!}
                        <label for="voeu1">Voeu 1 :</label><br>
                        <select name="voeu1" >
                            <option value="0">Sélectionnez votre sport</option>
                            @if($selected1->isNotEmpty())
                                @foreach($selected1 as $select)
                                    @if ($select->rank == '1' )
                                        @foreach($creneaux as $creneau)
                                            @if($select->session_id == $creneau->id)
                                                <option value="{{$creneau->id}}" selected>{{$creneau->label}}
                                                    : {{$creneau->dayOfWeek}}
                                                    de {{$creneau->startTime}} à {{$creneau->endTime}}
                                                    - {{$creneau->name}}</option>
                                            @else
                                                <option value="{{$creneau->id}}">{{$creneau->label}}
                                                    : {{$creneau->dayOfWeek}}
                                                    de {{$creneau->startTime}} à {{$creneau->endTime}}
                                                    - {{$creneau->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                @foreach($creneaux as $creneau)
                                    <option value="{{$creneau->id}}">{{$creneau->label}}
                                        : {{$creneau->dayOfWeek}}
                                        de {{$creneau->startTime}} à {{$creneau->endTime}}
                                        - {{$creneau->name}}</option>
                                @endforeach
                            @endif

                        </select>
                            <br>
                            @forelse($selected1 as $select)
                                @if( $select->rank == '1')
                                    <input type="checkbox"
                                           @if($select->spareTime)
                                           checked="selected"
                                           @endif
                                           id="isNotedFirstWish" name="isNotedFirstWish"><span> Je désire être noté</span>
                                @endif
                                @empty
                                <input type="checkbox"  id="isNotedFirstWish" name="isNotedFirstWish"><span> Je désire être noté</span>

                            @endforelse
                            <br>
                        <label for="voeu2">Voeu 2 :</label><br>
                        <select name="voeu2">
                            <option value="0">Sélectionnez votre sport</option>
                            @if($selected2->isNotEmpty())
                                @foreach($selected2 as $select)
                                    @if ($select->rank == '2' )
                                        @foreach($creneaux as $creneau)
                                            @if($select->session_id == $creneau->id)
                                                <option value="{{$creneau->id}}" selected>{{$creneau->label}}
                                                    : {{$creneau->dayOfWeek}}
                                                    de {{$creneau->startTime}} à {{$creneau->endTime}}
                                                    - {{$creneau->name}}</option>
                                            @else
                                                <option value="{{$creneau->id}}">{{$creneau->label}}
                                                    : {{$creneau->dayOfWeek}}
                                                    de {{$creneau->startTime}} à {{$creneau->endTime}}
                                                    - {{$creneau->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                @foreach($creneaux as $creneau)
                                    <option value="{{$creneau->id}}">{{$creneau->label}}
                                        : {{$creneau->dayOfWeek}}
                                        de {{$creneau->startTime}} à {{$creneau->endTime}}
                                        - {{$creneau->name}}</option>
                                @endforeach
                            @endif
                        </select>
                            <br>
                            @forelse($selected2 as $select)
                                @if( $select->rank == '2')
                                    <input type="checkbox"
                                           @if($select->spareTime)
                                           checked="selected"
                                           @endif
                                           id="isNotedSecondWish" name="isNotedSecondWish"><span> Je désire être noté</span>
                                @endif
                                @empty
                                <input type="checkbox" id="isNotedSecondWish" name="isNotedSecondWish"><span> Je désire être noté</span>
                            @endforelse
                            <br>
                            <label for="voeu3">Voeu 3 :</label><br>
                        <select name="voeu3">
                            <option value="0">Sélectionnez votre sport</option>
                            @if($selected3->isNotEmpty())
                                @foreach($selected3 as $select)
                                    @if ($select->rank == '3' )
                                        @foreach($creneaux as $creneau)
                                            @if($select->session_id == $creneau->id)
                                                <option value="{{$creneau->id}}" selected>{{$creneau->label}}
                                                    : {{$creneau->dayOfWeek}}
                                                    de {{$creneau->startTime}} à {{$creneau->endTime}}
                                                    - {{$creneau->name}}</option>
                                            @else
                                                <option value="{{$creneau->id}}">{{$creneau->label}}
                                                    : {{$creneau->dayOfWeek}}
                                                    de {{$creneau->startTime}} à {{$creneau->endTime}}
                                                    - {{$creneau->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                @foreach($creneaux as $creneau)
                                    <option value="{{$creneau->id}}">{{$creneau->label}}
                                        : {{$creneau->dayOfWeek}}
                                        de {{$creneau->startTime}} à {{$creneau->endTime}}
                                        - {{$creneau->name}}</option>
                                @endforeach
                            @endif
                        </select>
                            <br>

                            @forelse($selected3 as $select)
                                @if( $select->rank == '3')
                                    <input type="checkbox"
                                           @if($select->spareTime)
                                           checked="selected"
                                           @endif
                                           id="isNotedThirdWish" name="isNotedThirdWish"><span> Je désire être noté</span>
                                @endif
                                @empty
                                <input type="checkbox" id="isNotedThirdWish" name="isNotedThirdWish"><span> Je désire être noté</span>

                            @endforelse
                            {!! BootForm::submit("Ajouter le(s) voeu(x)")->class('btn btn-success') !!}
                        {!! BootForm::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection