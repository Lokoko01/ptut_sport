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
                            {!! BootForm::text('Nom', 'lastname') !!}
                            {!! BootForm::text('Prénom', 'firstname') !!}
                            {!! BootForm::date('Date de naissance', 'dateOfBirth') !!}
                            <div class="form-group">
                                {!! Form::label('sex', 'Sexe', array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-6">
                                    {{ Form::radio('sex', 'male', true) }}  {!! Form::label('male', 'Homme') !!}<br>
                                    {{ Form::radio('sex', 'female') }}  {!! Form::label('female', 'Femme') !!}
                                </div>
                            </div>
                            {!! BootForm::email('Email', 'email') !!}
                            {!! BootForm::select('Unité de Formation de Recherche', 'ufr')->options($ufrs) !!}
                            {!! BootForm::password('Mot de passe', 'password') !!}
                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmation de mot de passe</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>
                            {!! BootForm::submit("S'inscrire")->class('btn btn-primary') !!}
                            {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
