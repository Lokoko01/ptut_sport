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
    Route::get('/addProfessor','AdminController@registerprofessor');
    Route::get('/assignnote','AdminController@assignnote');
    Route::get('/addAdmin', 'AdminController@addAdmin');
});

Auth::routes();

Route::post('/professorRegister', 'Auth\RegisterProfessorController@register')->name('register_professor');

Route::get('/register/{studentEmail}/{token}', 'Auth\RegisterController@showRegistrationForm')->name('register_with_token');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/sendmail', 'ContactController@store')->name('sendmail');

Route::get('/professor/main', function(){
    return view('professor.main');
});

Route::post('/adminRegister', 'Auth\RegisterAdminController@register')->name('register_admin');