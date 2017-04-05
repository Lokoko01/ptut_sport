@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Renseigner les absents</div>
                    <div class="panel-body">
                        {!! BootForm::open() !!}
                        {{--@foreach($students as $student)
                            {!! BootForm::checkbox($student, 'check')->defaultCheckedState(null) !!}
                        @endforeach
                        {!! BootForm::close() !!}--}}

                        {{ dump(DB::table('students')
                                ->join('users', 'users.id', '=', 'students.user_id')
                                ->select('users.lastname', 'users.firstname')
                                ->get()) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection