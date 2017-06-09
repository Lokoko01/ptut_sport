@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading">Accueil - Admin</div>
                    <div class="panel panel-default">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="panel-body panel-admin panel-home">
                            <div class="button-admin flex-div">
                                <a href="{{route('add_professor')}}" class="btn btn-default">Ajouter un
                                    professeur</a><br>
                                <a href="{{route('add_admin')}}" class="btn btn-default">Ajouter un admin</a><br>
                                <a href="{{route('sport')}}" class="btn btn-default">Editer les
                                    sports</a><br>
                                <a href="{{route('location')}}" class="btn btn-default">Editer les lieux</a><br>
                                <a href="{{route('timeSlot')}}" class="btn btn-default">Editer les créneaux</a><br>
                                <a href="{{route('add_session')}}" class="btn btn-default">Ajouter une séance</a><br>
                                <a href="{{ route('students')}}" class="btn btn-default">Editer les érutiants</a><br>
                                <a href="{{ route('students_by_sport_excel_admin')}}" class="btn btn-default">Liste des
                                    étudiants par sport <i class="fa fa-file-excel-o"></i></a><br>
                                <a href="{{route('sortsWishes')}}" class="btn btn-default">Lancer l'attribution des
                                    sports</a><br>
                                {{--<a href="{{ route('home') }}" class="btn btn-default" disabled>RAZ de l'année</a><br>--}}
                                <a href="{{ route('admin_message') }}" class="btn btn-default">Envoyer un message</a><br>
                            </div>
                            <div class="informations-messages flex-div">
                                <h3>
                                    Informations
                                </h3>
                                <table class="main-table">
                                    @foreach($myMessages as $message)
                                        <tr>
                                            <td>
                                                {{ Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                {{ $message->message }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div class="text-center">
                                    {!! $myMessages->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection