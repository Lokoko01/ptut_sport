@extends('layouts.free')

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
                        @if(session()->has('error'))
                        <div class="alert alert-warning">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <div class="panel-heading">Se préinscrire</div>
                    <div class="panel-body">
                        <?php
                        $columnSizes = [
                            'md' => [4, 6]
                        ];
                        ?>

                        {!! BootForm::openHorizontal($columnSizes)->action(route('sendmail')) !!}
                        {!! BootForm::email('Email étudiant', 'studentEmail') !!}

                        <p>
                            Merci de renseigner votre adresse mail étudiante pour vérifier que vous êtes bien étudiant.
                            Un email vous sera envoyé à cette adresse contenant un lien vers le formulaire
                            d'inscription.
                            Vous pourrez choisir à ce moment là quelle adresses mail vous souhaitez utiliser pour
                            recevoir les emails concernant le sport.
                            <br>
                            <br>
                            Si vous ne possèdez pas d'adresse mail étudiante, <a href="#">cliquez ici</a> pour contacter
                            l'administrateur.
                        </p>

                        {!! BootForm::submit("Envoyer")->class('btn btn-primary') !!}
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection