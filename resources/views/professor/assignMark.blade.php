@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    {{--                    <div class="panel-heading">Ajout des notes pour le sport : {!! $students[0]->sport_label !!}</div>--}}
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'sm' => [5, 4],
                            'md' => [5, 4],
                            'lg' => [5, 4]
                        ];
                        ?>
                            {{$sessionSelect=false}}
                            @foreach($sessions as $session)
                                @if(isset($sessionId) && $session->id == $sessionId)
                                    <?php $sessionSelect=true ?>
                                    <h4>{{$session->label}}
                                        - {{$session->dayOfWeek}} {{$session->startTime}} : {{$session->endTime}}
                                        - {{$session->name}} ({{$session->city}})</h4>
                                @endif
                            @endforeach
                            @if($sessionSelect == false)
                        {!! BootForm::openHorizontal($columnSizes)->action(route('getStudentsBySessions')) !!}
                        <label for="select_sessions">Choisir la séance</label>
                        <br>
                        <select name="select_sessions">
                            <option value="0">Selectionnez votre séance</option>
                            @foreach($sessions as $session)
                                    <option value="{{$session->id}}">{{$session->label}}
                                        - {{$session->dayOfWeek}} {{$session->startTime}} : {{$session->endTime}}
                                        - {{$session->name}} ({{$session->city}})
                                    </option>
                            @endforeach
                        </select>
                        {!! BootForm::hidden('view')->value('assignMark') !!}
                            {!! BootForm::submit("Valider")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                            @endif


                        @isset($students)
                        {!! BootForm::openHorizontal($columnSizes)->action(route('addMarks')) !!}
                        @foreach($students as $student)
                            <div style="float: left">
                                {!! BootForm::hidden('students[' . $loop->index . '][student_id]')->value($student->student_id) !!}
                                        {!! BootForm::text($student->full_name, 'students[' . $loop->index . '][mark]')->attribute('type','number')->max(20)->min(0)->step('any')->value($student->mark) !!}
                            </div>
                            <div style="margin-bottom: 20px">
                                {!! Form::textarea('students[' . $loop->index . '][comment]', $student->comment, ['class' => 'form-control', 'size' => '20x3']) !!}
                            </div>

                        @endforeach
                        {!! BootForm::hidden('sessionId')->value($sessionId) !!}
                        {!! BootForm::submit("Ajouter les notes")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection