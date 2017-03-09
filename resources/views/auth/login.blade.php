@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">S'identifier</div>
                <div class="panel-body">
                    <?php
                    $columnSizes = [
                        'md' => [4, 6]
                    ];
                    ?>
                    {!! BootForm::openHorizontal($columnSizes)->action(route('login')) !!}
                    {!! BootForm::email('Email', 'email') !!}
                    {!! BootForm::password('Mot de passe', 'password') !!}
                    {!! BootForm::submit("S'identifier")->class('btn btn-primary')  !!}
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
