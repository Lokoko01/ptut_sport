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

Route::get('/preregister/', function () {
    return view('auth.preregister');
})->name('preregister');

Route::group(['prefix' => 'admin', 'roles' => 'admin'], function () {
    Route::get('/home', 'AdminController@index');
    Route::get('/listStudents', 'AdminController@showListOfStudents')->name('students');
    Route::get('/listStudents/search', 'AdminController@showStudentsBySearch')->name('students_by_search');
    Route::get('/downloadExcel/{type}', 'AdminController@downloadExcel');
    Route::get('/assignnote','AdminController@assignnote');
    Route::get('/addSession', 'AdminController@addsession')->name('add_session');
    Route::get('/addAdmin', 'AdminController@addAdmin')->name('add_admin');
    Route::get('/addProfessor','AdminController@registerprofessor')->name('add_professor');
    Route::get('/sports','AdminController@sport')->name('sport');
    Route::get('/ufr','AdminController@ufr')->name('Ufr');
    });

Route::group(['prefix' => 'student', 'roles' => 'student'], function() {
    Route::get('/choose_sport', 'StudentController@chooseSport')->name('chooseSport');
});
Route::post('/addWishesToStudent','WishesController@addWishesToStudent')->name('addWishesToStudent');

Route::group(['prefix' => 'professor', 'roles' => 'professor'], function() {
    Route::get('/checkAbsences', 'ProfessorController@check')->name("checkAbsences");
    Route::post('/getStudentsBySessions', 'ProfessorController@getStudentsBySessions')->name("getStudentsBySessions");
    Route::get('/main', function(){
        return view('professor.main');
    });
    Route::post('/addAbsences', 'AbsencesController@addAbsences')->name('addAbsences');
});

Auth::routes();

Route::post('/ufrRegister', 'UfrController@addUfr')->name('ufrRegister');
Route::post('/updateUfr', 'UfrController@updateUfr')->name('updateUfr');
Route::post('/deleteUfr', 'UfrController@deleteUfr')->name('deleteUfr');

Route::post('/sportRegister', 'SportController@addSport')->name('sportRegister');

Route::post('/updateSport', 'SportController@updateSport')->name('updateSport');

Route::post('/deleteSport', 'SportController@deleteSport')->name('deleteSport');

Route::post('/professorRegister', 'Auth\RegisterProfessorController@register')->name('register_professor');

Route::get('/register/{studentEmail}/{token}', 'Auth\RegisterController@showRegistrationForm')->name('register_with_token');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/sendmail', 'ContactController@store')->name('sendmail');


Route::post('/newSession', 'AddSessionController@add')->name('register_session');

Route::post('/adminRegister', 'Auth\RegisterAdminController@register')->name('register_admin');
