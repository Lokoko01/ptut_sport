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
                                    {!! Auth::user()->displaySportOrWish() !!}
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
                                    {!! Auth::user()->displayMissings() !!}
                                </table>
                            </div>
                        </div>
                        <div class="informations-messages flex-div">
                            <h3>
                                Informations
                            </h3>
                            <table class="main-table">
                                @foreach($myMessages as $message)
                                    <tr>
                                        <td>
                                            {{ Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            {{ $message->message }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="text-center">
                                {!! $myMessages->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection