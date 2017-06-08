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
                                <th>
                                    Editer
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
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-warning"
                                                data-toggle="modal"
                                                data-target="#{{$student->studentNumber}}ModalEditProfile">
                                            <i class="fa fa-user"></i>
                                        </button>
                                        <div class="modal fade" id="{{$student->studentNumber}}ModalEditProfile"
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
                                                            id="favoritesModalLabel">Modifier l'étudiant</h4>
                                                    </div>
                                                    {!! BootForm::openHorizontal($columnSizes)->action(route('edit_student')) !!}
                                                    {!! BootForm::hidden('user_id')->value($student->user_id) !!}
                                                    {!! BootForm::text('Numéro étudiant', 'student_number')->value($student->studentNumber) !!}
                                                    {!! BootForm::text('Nom', 'student_lastname')->value($student->lastname) !!}
                                                    {!! BootForm::text('Prénom', 'student_firstname')->value($student->firstname) !!}
                                                    {!! BootForm::text('Email d\'inscription', 'student_email')->value($student->email) !!}
                                                    {!! BootForm::text('E-mail privé', 'student_private_email')->value($student->privateEmail) !!}
                                                    {!! BootForm::submit("Valider")->class('btn btn-primary') !!}
                                                    {!! BootForm::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{route('studentInfos')}}" method="get">
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
