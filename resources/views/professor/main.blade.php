@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Accueil - Professeur</div>
                    <div class="panel-body panel-professor">
                        <div class="button-professor">
                            <a href="{{ route('checkAbsences') }}" class="btn btn-default">Faire l'appel</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Générer la feuille d'appel au format
                                PDF</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Générer la feuille d'appel au format
                                Excel</a><br>
                            <a href="{{ route('assignMark') }}" class="btn btn-default">Rentrer les notes des
                                étudiants</a><br>
                            <a href="{{ route('home') }}" class="btn btn-default">Envoyer un message aux
                                étudiants</a><br>
                        </div>
                        <div class="informations-messages">
                            <h3>
                                Informations
                            </h3>
                            <table class="message-table">
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
@endsection