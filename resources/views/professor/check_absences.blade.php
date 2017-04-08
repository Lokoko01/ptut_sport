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
                        <table class="table">
                            <th>
                                Étudiant
                            </th>
                            <th>
                                UFR
                            </th>
                            {!! BootForm::openHorizontal($columnSizes)->action(route('makeCall')) !!}
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


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection