@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Accueil - Professeur</div>
                    <div class="panel-body panel-admin panel-home">
                        <div class="button-admin flex-div">
                            <a href="/admin/addSession" class="btn btn-default">Ajouter une séance</a><br>
                            <a href="/admin/addProfessor" class="btn btn-default">Ajouter un professeur</a><br>
                            <a href="/admin/addAdmin" class="btn btn-default">Ajouter un admin</a><br>
                            <a href="/admin/addAdmin" class="btn btn-default">Ajouter un sport</a><br>

                            <a href="{{ route('home') }}" class="btn btn-default">Editer une note</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Désinscrire un étudiant</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Ajouter un étudiant à un sport</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Générer un fichier Excel des notes</a><br>
                            <a href="/admin/listStudents" class="btn btn-default">Afficher la liste des étudiants</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">RAZ le semestre</a><br>
                        </div>
                        <div class="informations-messages flex-div">
                            <h3>
                                Informations
                            </h3>
                            <table class="main-table">
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et. Quisque sed justo odio. Aliquam laoreet.</td>
                                </tr>
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et. Quisque sed justo odio. Aliquam laoreet.</td>
                                </tr>
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et. Quisque sed justo odio. Aliquam laoreet.</td>
                                </tr>
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et. Quisque sed justo odio. Aliquam laoreet.</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection