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


Auth::routes();

Route::get('/register/{studentEmail}/{token}', 'Auth\RegisterController@showRegistrationForm')->name('register_with_token');

Route::get('/home', 'HomeController@index');

Route::post('/sendmail', 'ContactController@store')->name('sendmail');

Route::get('/professor', function (){
    return view('auth.registerprofessor');
});

Route::post('/professorRegister', 'Auth\RegisterProfessorController@register')->name('register_professor');