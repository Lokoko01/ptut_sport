<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/preregister/', function (){
    return view('auth.preregister');
})->name('preregister');

Route::group(['prefix' => 'admin', 'roles' => 'admin'], function() {
    Route::get('/home', 'AdminController@index');
    Route::get('/addSession', 'AdminController@addsession');
    Route::get('/addAdmin', 'AdminController@addAdmin');
    Route::get('/professor','AdminController@registerprofessor');
    Route::get('/sports','AdminController@sport')->name('sport');
    Route::get('/ufr','AdminController@ufr')->name('Ufr');
    });

Route::group(['prefix' => 'professor', 'roles' => 'professor'], function() {
    Route::get('/checkAbsences', 'ProfessorController@check')->name("checkAbsences");
    Route::get('/assignMark', 'ProfessorController@assignMark')->name("assignMark");
    Route::get('/main', function(){
        return view('professor.main');
    });
});

Auth::routes();

Route::post('/ufrRegister','UfrController@addUfr')->name('ufrRegister');
Route::post('/updateUfr','UfrController@updateUfr')->name('updateUfr');
Route::post('/deleteUfr','UfrController@deleteUfr')->name('deleteUfr');

Route::post('/sportRegister','SportController@addSport')->name('sportRegister');

Route::post('/updateSport','SportController@updateSport')->name('updateSport');

Route::post('/deleteSport','SportController@deleteSport')->name('deleteSport');

Route::post('/professorRegister', 'Auth\RegisterProfessorController@register')->name('register_professor');

Route::get('/register/{studentEmail}/{token}', 'Auth\RegisterController@showRegistrationForm')->name('register_with_token');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/sendmail', 'ContactController@store')->name('sendmail');

Route::post('/professor/makeCall', 'AbsencesController@addAbsences')->name('makeCall');

Route::post('/professor/addMarks', 'MarksController@addMarks')->name('addMarks');

Route::post('/newSession', 'AddSessionController@add')->name('add_session');

Route::post('/adminRegister', 'Auth\RegisterAdminController@register')->name('register_admin');


