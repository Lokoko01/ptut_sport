@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(session()->has('message_sucess_admin'))
                        <div class="alert alert-success">
                            {{ session()->get('message_sucess_admin') }}
                        </div>
                    @endif
                    <div class="panel-heading">S'inscrire</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>

                        {!! BootForm::openHorizontal($columnSizes)->action(route('register_admin')) !!}

                        {!! BootForm::text('Nom', 'lastname') !!}
                        {!! BootForm::text('Prénom', 'firstname') !!}

                        {!! BootForm::inlineRadio('Homme', 'sex', 'male') !!}
                        {!! BootForm::inlineRadio('Femme', 'sex', 'female') !!}

                        {!! BootForm::email('Email', 'email') !!}
                        {!! BootForm::password('Mot de passe', 'password') !!}
                        {!! BootForm::password('Confirmation du mot de passe', 'password_confirmation') !!}
                        {!! BootForm::submit("Inscrire")->class('btn btn-primary') !!}

                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
