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

                        {!! BootForm::openHorizontal($columnSizes)->action(route('register')) !!}
                        {!! BootForm::hidden('token')->value($token) !!}
                        {!! BootForm::text('Numéro étudiant', 'studentNumber') !!}

                        {!! BootForm::text('Nom', 'lastname') !!}
                        {!! BootForm::text('Prénom', 'firstname') !!}

                        {!! BootForm::select('Niveau d\'étude', 'studyLevel')
                            ->options(['1' => '1ère année', '2' => '2ème année', '3' => '3ème année', '4' => '4ème année', '5' => '5ème année']) !!}

                        {!! BootForm::inlineRadio('Homme', 'sex', 'male') !!}
                        {!! BootForm::inlineRadio('Femme', 'sex', 'female') !!}

                        {!! BootForm::email('Email personnel', 'privateEmail') !!}
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
