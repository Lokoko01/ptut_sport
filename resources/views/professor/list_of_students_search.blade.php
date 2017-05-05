@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if(session()->has('ufrAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('ufrAlreadyExist') }}
                        </div>
                    @endif
                    <div class="panel-heading">Liste des étudiants - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">

                        <?php
                        $columnSizes = [
                            'md' => [0, 8]
                        ];
                        ?>

                        {{-- Search bar --}}
                        <form action="{{ route('students_by_search') }}" method="get"
                              class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="search" name="q" class="form-control"
                                       value="{{Request::hasSession() ? old('q') : ''}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Rechercher</button>
                        </form>

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    Numéro étudiant
                                </th>
                                <th>
                                    Nom
                                </th>
                                <th>
                                    Prénom
                                </th>
                                <th>
                                    E-mail étudiant
                                </th>
                            </tr>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        {{$student->studentNumber}}
                                    </td>
                                    <td>
                                        {{$student->lastname}}
                                    </td>
                                    <td>
                                        {{$student->firstname}}
                                    </td>
                                    <td>
                                        {{$student->email}}
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
