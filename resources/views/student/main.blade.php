@extends("layouts.app")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Accueil - Etudiant</div>
                    <div class="panel-body panel-student panel-home">
                        <div class="flex-div student-container">
                            <div class="student-sports flex-div">
                                <h3>
                                    Mes sports
                                </h3>
                                <table class="main-table">
                                    {!! Auth::user()->displaySessions() !!}
                                </table>
                            </div>
                            <div class="student-marks flex-div">
                                <h3>
                                    Mes notes
                                </h3>
                                <table class="main-table">
                                    {!! Auth::user()->displayMarks() !!}
                                </table>
                            </div>
                            <div class="student-missings flex-div">
                                <h3>
                                    Mes absences
                                </h3>
                                <table class="main-table">
                                    <tr>
                                        <td>Absence 1 (date) : Justifiée</td>
                                    </tr>
                                    <tr>
                                        <td>Absence 2 (date) : Non Justifiée</td>
                                    </tr>
                                    <tr>
                                        <td>Absence 3 (date) : Justifiée</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="informations-messages flex-div">
                            <h3>
                                Informations
                            </h3>
                            <table class="main-table">
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh
                                        tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et.
                                        Quisque sed justo odio. Aliquam laoreet.
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh
                                        tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et.
                                        Quisque sed justo odio. Aliquam laoreet.
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh
                                        tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et.
                                        Quisque sed justo odio. Aliquam laoreet.
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a massa sed nibh
                                        tempor cursus. Vivamus imperdiet congue dolor, eget ultrices elit facilisis et.
                                        Quisque sed justo odio. Aliquam laoreet.
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection