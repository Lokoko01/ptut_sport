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
    Route::get('/downloadExcel', 'AdminController@exportStudentsBySportExcel')->name('students_by_sport_excel_admin');
    Route::get('/downloadPdf', 'AdminController@exportStudentsBySportPdf')->name('students_by_sport_pdf_admin');
    Route::get('/assignnote','AdminController@assignnote');
    Route::get('/addSession', 'AdminController@addsession')->name('add_session');
    Route::get('/addAdmin', 'AdminController@addAdmin')->name('add_admin');
    Route::get('/addProfessor','AdminController@registerprofessor')->name('add_professor');
    Route::get('/sports','AdminController@sport')->name('sport');
    Route::get('/locations','AdminController@locations')->name('location');
    Route::get('/timeSlots','AdminController@timeSlots')->name('timeSlot');
    Route::get('/ufr','AdminController@ufr')->name('Ufr');
    Route::get('/message','AdminController@Message')->name('admin_message');
    Route::get('/studentInfos', 'AdminController@studentInfos')->name('studentInfos');
    Route::get('/sortsWishes','AdminController@sortsWishes')->name('sortsWishes');
});

Route::group(['prefix' => 'student', 'roles' => 'student'], function() {
    Route::get('/choose_sport', 'StudentController@chooseSport')->name('chooseSport');
});
Route::post('/addWishesToStudent','WishesController@addWishesToStudent')->name('addWishesToStudent');

Route::group(['prefix' => 'professor', 'roles' => 'professor'], function() {
    Route::get('/checkAbsences', 'ProfessorController@check')->name("checkAbsences");
    Route::get('/downloadExcel', 'ProfessorController@exportStudentsBySportExcel')->name('students_by_sport_excel_prof');
    Route::get('/downloadPdf', 'ProfessorController@exportStudentsBySportPdf')->name('students_by_sport_pdf_prof');
    Route::get('/assignMark', 'ProfessorController@mark')->name("assignMark");
    Route::post('/getStudentsBySessions', 'ProfessorController@getStudentsBySessions')->name("getStudentsBySessions");
    Route::get('/message','ProfessorController@Message')->name('professor_message');
    Route::get('/main', function(){
        return view('professor.main');
    });
    Route::post('/addAbsences', 'AbsencesController@addAbsences')->name('addAbsences');
});

Auth::routes();

Route::post('/ufrRegister', 'UfrController@addUfr')->name('ufrRegister');
Route::post('/updateUfr', 'UfrController@updateUfr')->name('updateUfr');
Route::post('/deleteUfr', 'UfrController@deleteUfr')->name('deleteUfr');

Route::post('/addMessage', 'MessageController@addMessage')->name('addMessage');
Route::post('/addMessageProfessor', 'MessageProfessorController@addMessage')->name('addMessageProfessor');
Route::post('/deleteMessage', 'MessageController@deleteMessage')->name('deleteMessage');

Route::post('/sortsWishesConfirm', 'SortsController@validateSorts')->name('sortsWishesConfirm');

Route::post('/sportRegister', 'SportController@addSport')->name('sportRegister');
Route::post('/updateSport', 'SportController@updateSport')->name('updateSport');
Route::post('/deleteSport', 'SportController@deleteSport')->name('deleteSport');

Route::post('/locationRegister', 'LocationController@addLocation')->name('locationRegister');
Route::post('/updateLocation', 'LocationController@updateLocation')->name('updateLocation');
Route::post('/deleteLocation', 'LocationController@deleteLocation')->name('deleteLocation');

Route::post('/timeSlotRegister', 'TimeSlotController@addTimeSlot')->name('timeSlotRegister');
Route::post('/updateTimeSlot', 'TimeSlotController@updateTimeSlot')->name('updateTimeSlot');
Route::post('/deleteTimeSlot', 'TimeSlotController@deleteTimeSlot')->name('deleteTimeSlot');

Route::post('/professorRegister', 'Auth\RegisterProfessorController@register')->name('register_professor');

Route::get('/register/{studentEmail}/{token}', 'Auth\RegisterController@showRegistrationForm')->name('register_with_token');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/sendmail', 'ContactController@store')->name('sendmail');

Route::post('/professor/makeCall', 'AbsencesController@addAbsences')->name('makeCall');

Route::post('/professor/addMarks', 'MarkController@addMarks')->name('addMarks');

Route::post('/newSession', 'AddSessionController@add')->name('register_session');

Route::post('/adminRegister', 'Auth\RegisterAdminController@register')->name('register_admin');

Route::post('/editStudent', 'AdminController@editStudent')->name('edit_student');

Route::post('/editAbsence', 'AdminController@editAbsence')->name('edit_absence');

Route::post('/editMark', 'AdminController@editMark')->name('edit_mark');

Route::post('/deleteSession', 'AdminController@deleteSession')->name('delete_session');

Route::post('/affectSession', 'AdminController@affectSession')->name('affect_session');