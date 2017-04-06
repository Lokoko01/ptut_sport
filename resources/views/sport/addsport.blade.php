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
                    @if(session()->has('sportAlreadyExist'))
                        <div class="alert alert-warning">
                            {{ session()->get('sportAlreadyExist') }}
                        </div>
                    @endif
                    <div class="panel-heading">Accueil - {{ Auth::user()->afficheRole() }}</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('sportRegister')) !!}
                        {!! BootForm::text('Sport', 'sport') !!}
                        {!! BootForm::submit("Ajouter le sport")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
@endsection
