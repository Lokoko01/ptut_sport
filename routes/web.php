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
    Route::get('/professor','AdminController@registerprofessor');
    Route::get('/addsport','AdminController@addsport')->name('addSport');
    Route::get('/addufr','AdminController@addufr')->name('addUfr');
    });

Auth::routes();

Route::post('/ufrRegister','UfrController@addUfr')->name('ufrRegister');
Route::post('/sportRegister','SportController@addSport')->name('sportRegister');

Route::post('/professorRegister', 'Auth\RegisterProfessorController@register')->name('register_professor');

Route::get('/register/{studentEmail}/{token}', 'Auth\RegisterController@showRegistrationForm')->name('register_with_token');

Route::get('/home', 'HomeController@index');

Route::post('/sendmail', 'ContactController@store')->name('sendmail');
