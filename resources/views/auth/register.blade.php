@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">S'inscrire</div>
                    <div class="panel-body">
                    <?php
                    $columnSizes = [
                        'md' => [4, 6]
                    ];
                    ?>

                    <!-- Pour faire un form bien on peut utiliser celui la avec le $columnSizes d'enhaut-->
                        {{--  {!! BootForm::openHorizontal($columnSizes)->action(route('register')) !!}--}}

                        {!! BootForm::open()->action(route('register')) !!}

                        {!! BootForm::text('Nom', 'lastname') !!}
                        {!! BootForm::text('Prénom', 'firstname') !!}
                        {!! BootForm::date('Date de naissance', 'dateOfBirth') !!}

                        {!! BootForm::inlineRadio('Homme', 'sex', 'male') !!}
                        {!! BootForm::inlineRadio('Femme', 'sex', 'female') !!}

                        {!! BootForm::email('Email', 'email') !!}
                        {!! BootForm::select('Unité de Formation de Recherche', 'ufr')->options($ufrs) !!}
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
