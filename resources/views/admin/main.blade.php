@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Accueil - Professeur</div>
                    <div class="panel-body panel-admin panel-home">
                        <div class="button-admin flex-div">
                            <a href="{{route('add_session')}}" class="btn btn-default">Ajouter une séance</a><br>
                            <a href="{{route('add_professor')}}" class="btn btn-default">Ajouter un professeur</a><br>
                            <a href="{{route('add_admin')}}" class="btn btn-default">Ajouter un admin</a><br>
                            <a href="{{route('sport')}}" class="btn btn-default">Ajouter un sport</a><br>

                            <a href="{{ route('home') }}" class="btn btn-default">Editer une note</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Désinscrire un étudiant</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Ajouter un étudiant à un sport</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Générer un fichier Excel des notes</a><br>
                            <a href="{{ route('students')}}" class="btn btn-default">Afficher la liste des étudiants</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">RAZ le semestre</a><br>
                            <a href="{{ route('message') }}" class="btn btn-default">Envoyer un message</a><br>
                        </div>
                        <div class="informations-messages flex-div">
                            <h3>
                                Informations
                            </h3>
                            <table class="main-table">
                                {!! Auth::user()->displayMessage() !!}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection