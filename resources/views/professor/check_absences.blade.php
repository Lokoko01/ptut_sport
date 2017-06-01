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
                            'md' => [2, 8]
                        ];
                        ?>

                        {!! BootForm::openHorizontal($columnSizes)->action(route('makeCall')) !!}

                        @foreach($students as $student)
                                {!! BootForm::checkbox($student->full_name . ' -> ' . $student->label_ufr, 'check[]')->defaultCheckedState(null)->value($student->student_id) !!}
                        @endforeach
                        {!! BootForm::submit("Valider")->class('btn btn-primary') !!}

                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection