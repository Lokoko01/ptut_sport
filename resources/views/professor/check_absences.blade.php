@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Renseigner les absents</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [0, 8]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('getStudentsBySessions')) !!}
                        <label for="select_sessions">Choisir la séance</label>
                        <br>
                        <select name="select_sessions">
                            <option value="0">Selectionnez votre séance</option>
                            @foreach($sessions as $session)
                                @if(isset($sessionId) && $session->id == $sessionId)
                                    <option value="{{$session->id}}" selected>{{$session->label}}
                                        - {{$session->dayOfWeek}} {{$session->startTime}} : {{$session->endTime}}
                                        - {{$session->name}} ({{$session->city}})
                                    </option>
                                @else
                                    <option value="{{$session->id}}">{{$session->label}}
                                        - {{$session->dayOfWeek}} {{$session->startTime}} : {{$session->endTime}}
                                        - {{$session->name}} ({{$session->city}})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        {!! BootForm::submit("Valider")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                        @isset($students)
                        {!! BootForm::openHorizontal($columnSizes)->action(route('addAbsences')) !!}
                        {!! BootForm::hidden('sessionId')->value($sessionId) !!}
                        {!! BootForm::radio("Aujourd'hui", "isToday")->attribute('id', 'today')->onChange('displayDate()')->defaultCheckedState(1)->value(1) !!}
                        {!! BootForm::radio("Une autre date", "isToday")->attribute('id', 'otherDate')->onChange('displayDate()')->value(0) !!}
                        {!! BootForm::text('', "dateSelector")->attribute('type', 'date')->id('dateSelector')->attribute('style', 'display: none')!!}
                        <table class="table">
                            <caption>Cocher les étudiants absents</caption>
                            <th>
                                Étudiant
                            </th>
                            <th>
                                UFR
                            </th>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        {!! BootForm::checkbox($student->full_name, 'check[]')->defaultCheckedState(null)->value($student->student_id) !!}
                                    </td>
                                    <td>
                                        {{$student->label_ufr}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! BootForm::submit("Valider")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function displayDate(){
            var otherDate = document.getElementById('otherDate');
            var dateSelector = document.getElementById('dateSelector');
            console.log('test');

            if(otherDate.checked == true){
                dateSelector.style.display = 'initial';
            } else {
                dateSelector.style.display = 'none';
            }
        }
    </script>
@endsection