@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if(session()->has('message_sucess_professor'))
                        <div class="alert alert-success">
                            {{ session()->get('message_sucess_professor') }}
                        </div>
                    @endif
                    <div class="panel-heading">Inscription professeur</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                        {!! BootForm::openHorizontal($columnSizes)->action(route('register_professor')) !!}

                        {!! BootForm::text('Nom', 'lastname') !!}
                        {!! BootForm::text('Prénom', 'firstname') !!}

                        {!! BootForm::inlineRadio('Homme', 'sex', 'male') !!}
                        {!! BootForm::inlineRadio('Femme', 'sex', 'female') !!}

                        {!! BootForm::email('Email', 'email') !!}
                        {!! BootForm::text('Numéro de téléphone', 'phone_number')!!}
                        {!! BootForm::password('Mot de passe', 'password') !!}
                        {!! BootForm::password('Confirmation du mot de passe', 'password_confirmation') !!}
                        {!! BootForm::submit("S'inscrire")->class('btn btn-primary') !!}

                        {!! BootForm::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
