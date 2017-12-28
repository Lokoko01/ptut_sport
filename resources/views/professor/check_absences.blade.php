@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        var datefield=document.createElement("input")
        datefield.setAttribute("type", "date")
        if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
            document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
            document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
            document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n')
        }
    </script>

    <script>
        if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
            jQuery(function($){ //on document.ready
                $('#dateSelector').datepicker({
                    dateFormat: 'dd.mm.yy',
                    monthNames: ['janv.','févr.', 'mars', 'avr.', 'mai','juin','juil','août','sept.','oct.','nov.','déc'],
                    dayNames: ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'],
                    dayNamesMin: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']
                });
            })
        }
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Renseigner les absents
                        <strong> <?php
                                if(isset($date)){
                        $source = $date;
                        $dateFR = new DateTime($source);

                        echo "du ".$dateFR->format('d-m-Y');
                        }
                        ?></strong>
                    </div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [0, 8]
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

                                {!! BootForm::radio("Aujourd'hui", "isToday")->attribute('id', 'today')->onChange('displayDate()')->defaultCheckedState(1)->value(1) !!}
                                {!! BootForm::radio("Une autre date", "isToday")->attribute('id', 'otherDate')->onChange('displayDate()')->value(0) !!}
                                {!! BootForm::text('', "dateSelector")->attribute('type', 'date')->id('dateSelector')->attribute('style', 'display: none')!!}

                                {!! BootForm::hidden('view')->value('check_absences') !!}
                                {!! BootForm::submit("Valider")->class('btn btn-primary') !!}
                                {!! BootForm::close() !!}
                            @endif
                        @isset($students)
                        {!! BootForm::openHorizontal($columnSizes)->action(route('addAbsences')) !!}
                        {!! BootForm::hidden('sessionId')->value($sessionId) !!}
                            {!! BootForm::hidden('date')->value($date) !!}

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
                                        {{$absencecheck=false}}
                                        @foreach($absences as $absence)
                                            @if($student->student_sport_id == $absence->student_sport_id)
                                                <?php $absencecheck=true ?>
                                        {!! BootForm::checkbox($student->full_name, 'check[]')->defaultCheckedState(1)->value($student->student_id) !!}
                                                @endif
                                        @endforeach
                                        @if(!$absencecheck)
                                                        {!! BootForm::checkbox($student->full_name, 'check[]')->defaultCheckedState(0)->value($student->student_id) !!}
                                        @endif
                                    </td>
                                    <td>
                                        {{$student->label_ufr}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        {!! BootForm::submit("Valider la saisie des absences")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        function displayDate() {
            var otherDate = document.getElementById('otherDate');
            var dateSelector = document.getElementById('dateSelector');
            console.log('test');

            if (otherDate.checked == true) {
                dateSelector.style.display = 'initial';
            } else {
                dateSelector.style.display = 'none';
            }
        }
    </script>
@endsection