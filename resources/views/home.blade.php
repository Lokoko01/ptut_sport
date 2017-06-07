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
                    <div class="panel-heading">Accueil - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        Connecté !
                        {{ dump(Auth::user()->student) }}
                        {{ dump(Auth::user()->student()) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
