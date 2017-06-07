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
                        <div class="alert alert-danger">
                            {{ session()->get('message_students_of_lyon_2_not_found') }}
                        </div>
                    @endif
                    @if(session()->has('ufrAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('ufrAlreadyExist') }}
                        </div>
                    @endif
                    <div class="panel-heading">Liste des étudiants - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">

                        {{-- Search bar --}}
                        <form action="{{ route('students_by_search') }}" method="get"
                              class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="search" name="q" class="form-control"
                                       value="{{Request::hasSession() ? old('q') : ''}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Rechercher un étudiant</button>
                        </form>
                        {{-- Search bar --}}
                        <div style="margin-top: 7px;">
                            <a href="{{ URL::to('/admin/downloadExcel/xls') }}">
                                <button class="btn btn-success">
                                    <i class="fa fa-file-excel-o"></i>
                                    Exporter la liste des étudiants
                                </button>
                            </a>
                        </div>

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
                                <th>
                                    Détails
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
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-primary"
                                                data-toggle="modal"
                                                data-target="#{{$student->studentNumber}}Modal">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <div class="modal fade" id="{{$student->studentNumber}}Modal"
                                             tabindex="-1" role="dialog"
                                             aria-labelledby="favoritesModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="favoritesModalLabel">Détail de l'étudiant</h4>
                                                    </div>
                                                    <table style="margin:auto;">
                                                        <tr>
                                                            <th style="padding: 0px 25px 25px 0px;">Numéro étudiant</th>
                                                            <td style="padding: 0px 25px 25px 0px;">{{$student->studentNumber}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="padding: 0px 25px 25px 0px;">Nom</th>
                                                            <td style="padding: 0px 25px 25px 0px;">{{$student->lastname}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="padding: 0px 25px 25px 0px;">Prénom</th>
                                                            <td style="padding: 0px 25px 25px 0px;">{{$student->firstname}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="padding: 0px 25px 25px 0px;">E-mail
                                                                d'inscription
                                                            </th>
                                                            <td style="padding: 0px 25px 25px 0px;">{{$student->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="padding: 0px 25px 25px 0px;">E-mail privé</th>
                                                            <td style="padding: 0px 25px 25px 0px;">{{$student->privateEmail}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="padding: 0px 25px 25px 0px;">Inscription</th>
                                                            <td style="padding: 0px 25px 25px 0px;">{{Carbon\Carbon::parse($student->created_at)->format('d/m/Y')}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
