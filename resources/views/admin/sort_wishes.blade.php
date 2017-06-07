@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Tri des voeux</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>
                            {!! BootForm::openHorizontal($columnSizes)->action(route('sortsWishesConfirm')) !!}
                            {!! BootForm::password('Mot de passe', 'password') !!}
                            {!! BootForm::radio('Tri avec les critères du s1','semestre',true) !!}
                            {!! BootForm::radio('Tri avec les critères du s2','semestre',false) !!}
                            {!! BootForm::submit("Lancer la répartition")->class('btn btn-primary')  !!}
                            {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection