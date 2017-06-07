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
                                <a href="{{route('sport')}}" class="btn btn-default">Ajouter / Supprimer un
                                    sport</a><br>
                                <a href="{{route('location')}}" class="btn btn-default">Ajouter un lieu</a><br>
                                <a href="{{route('timeSlot')}}" class="btn btn-default">Ajouter un créneau</a><br>
                                <a href="{{route('add_session')}}" class="btn btn-default">Ajouter une séance</a><br>
                                <a href="{{ route('students')}}" class="btn btn-default">Afficher la liste des
                                    étudiants</a><br>
                                <a href="{{ route('students_by_sport_excel')}}" class="btn btn-default">Liste des
                                    étudiants par sport <i class="fa fa-file-excel-o"></i></a><br>
                                <a href="{{ route('students_by_sport_pdf')}}" class="btn btn-default">Liste des
                                    étudiants par sport <i class="fa fa-file-pdf-o"></i></a><br>
                                <a href="{{route('sortsWishes')}}" class="btn btn-default">Lancer l'attribution des
                                    sports</a><br>
                                <a href="{{ route('home') }}" class="btn btn-default">RAZ de l'année</a><br>
                            </div>
                            <div class="informations-messages flex-div">
                                <h3>
                                    Informations
                                </h3>
                                <table class="main-table">
                                    <tr>
                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed
                                            nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit
                                            facilisis et. Quisque sed justo odio. Aliquam laoreet.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed
                                            nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit
                                            facilisis et. Quisque sed justo odio. Aliquam laoreet.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed
                                            nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit
                                            facilisis et. Quisque sed justo odio. Aliquam laoreet.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed
                                            nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit
                                            facilisis et. Quisque sed justo odio. Aliquam laoreet.
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection