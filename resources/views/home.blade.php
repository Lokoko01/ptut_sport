@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Accueil - {{ Auth::user()->afficheRole() }}</div>
                <div class="panel-body">
                    Connecté !
                    {{ var_dump(Auth::user()->student) }}
                </div>
            </div>
        </div>
    </div>
@endsection
