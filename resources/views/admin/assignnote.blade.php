@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ajouter une note</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'xs' => [5, 4],
                            'sm' => [3, 2],
                            'md' => [3, 2],
                            'lg' => [3, 2]
                        ];
                        ?>

                        {!! BootForm::openHorizontal($columnSizes) !!}
                        @foreach($students as $student)
                            {!! BootForm::label($student->full_name) !!}
                            {!! BootForm::text($student->sport_label, 'note') !!}
                        @endforeach
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection