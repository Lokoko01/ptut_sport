@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if(session()->has('message_students_of_lyon_2_not_found'))
                        <div class="alert alert-danger">
                            {{ session()->get('message_students_of_lyon_2_not_found') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if(session()->has('ufrAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('ufrAlreadyExist') }}
                        </div>
                    @endif
                    @if(session()->has('warning'))
                        <div class="alert alert-warning">
                            {{ session()->get('warning') }}
                        </div>
                    @endif
                    <div class="panel-heading">Liste des étudiants - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'sm' => [5, 4],
                            'md' => [5, 4],
                            'lg' => [5, 4]
                        ];
                        ?>
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    Nom
                                </th>
                                <th>
                                    Prénom
                                </th>
                                <th>
                                    E-mail étudiant
                                </th>
                                <th>Sport</th>
                                <th></th>
                            </tr>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        {{$student->lastname}}
                                    </td>
                                    <td>
                                        {{$student->firstname}}
                                    </td>
                                    <td>
                                        {{$student->email}}
                                    </td>
                                    <td>
                                        {{$student->label}}
                                    </td>
                                    <td>
                                        <form action="{{route('studentInfosProf')}}" method="get">
                                            <input type="hidden" name="userId" value="{{$student->user_id}}">
                                            <input type="submit" value="Plus d'informations" class="btn btn-default">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $students->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
