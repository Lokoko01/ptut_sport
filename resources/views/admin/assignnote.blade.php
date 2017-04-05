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
                            'md' => [4, 6]
                        ];
                        ?>

                        {!! BootForm::openHorizontal($columnSizes) !!}
                        @foreach($students as $student)
                            {!! BootForm::checkbox($student->full_name, 'check')->defaultCheckedState(null) !!}
                        @endforeach
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection