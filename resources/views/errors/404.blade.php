@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                        <h2 style="text-align: center;">Oops !</h2>
                       <a  href="{{URL::previous()}}">
                        <button type="button"  style="display: block; margin: auto;" class="btn btn-danger">
                            Retour à la page précédente
                        </button>
                       </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
