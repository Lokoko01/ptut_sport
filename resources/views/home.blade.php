@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Accueil</div>
                <div class="panel-body">
                    Connecté !
                    {{ dump(Auth::user()->student) }}
                    {{ dump(Auth::user()->isStudent()) }}
                </div>
            </div>
        </div>
    </div>
@endsection
