<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin'], function () {
  Route::get('/', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

  // Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
  // Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register']);

  Route::post('/password/email', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm']);

  Route::get('/home', [App\Http\Controllers\Admin\AdminController::class, 'index']);

  Route::get('/examinations', [App\Http\Controllers\Admin\AdminController::class, 'examinations'])->name('examinations');
  Route::post('/addExamination', [App\Http\Controllers\Admin\AdminController::class, 'addExamination'])->name('addExamination');
  Route::post('/updateExamination', [App\Http\Controllers\Admin\AdminController::class, 'updateExamination'])->name('updateExamination');
  Route::post('/deleteExamination', [App\Http\Controllers\Admin\AdminController::class, 'deleteExamination'])->name('deleteExamination');
  Route::get('/examination/{slug}', [App\Http\Controllers\Admin\AdminController::class, 'getExamination'])->name('getExamination');

  Route::get('/subjects', [App\Http\Controllers\Admin\AdminController::class, 'subjects'])->name('subjects');
  Route::post('/addSubject', [App\Http\Controllers\Admin\AdminController::class, 'addSubject'])->name('addSubject');
  Route::post('/updateSubject', [App\Http\Controllers\Admin\AdminController::class, 'updateSubject'])->name('updateSubject');
  Route::post('/deleteSubject', [App\Http\Controllers\Admin\AdminController::class, 'deleteSubject'])->name('deleteSubject');
  Route::get('/subject/{slug}', [App\Http\Controllers\Admin\AdminController::class, 'getSubject'])->name('getSubject');


  Route::get('/students', [App\Http\Controllers\Admin\AdminController::class, 'students'])->name('students');
  Route::post('/addSingleStudent', [App\Http\Controllers\Admin\AdminController::class, 'addSingleStudent'])->name('addSingleStudent');
  Route::post('/addBulkStudent', [App\Http\Controllers\Admin\AdminController::class, 'addBulkStudent'])->name('addBulkStudent');
  Route::post('/updateStudent', [App\Http\Controllers\Admin\AdminController::class, 'updateStudent'])->name('updateStudent');
  Route::post('/deleteStudent', [App\Http\Controllers\Admin\AdminController::class, 'deleteStudent'])->name('deleteStudent');

  Route::post('/addBulkCandidate', [App\Http\Controllers\Admin\AdminController::class, 'addBulkCandidate'])->name('addBulkCandidate');
  Route::post('/deleteCandidate', [App\Http\Controllers\Admin\AdminController::class, 'deleteCandidate'])->name('deleteCandidate');
  
  Route::post('/generateCandidateQuestions', [App\Http\Controllers\Admin\AdminController::class, 'generateCandidateQuestions'])->name('generateCandidateQuestions');

  Route::post('/uploadBulkQuestion', [App\Http\Controllers\Admin\AdminController::class, 'uploadBulkQuestion'])->name('uploadBulkQuestion');
  Route::post('/deleteOption', [App\Http\Controllers\Admin\AdminController::class, 'deleteOption'])->name('deleteOption');
  Route::post('/updateOption', [App\Http\Controllers\Admin\AdminController::class, 'updateOption'])->name('updateOption');
  Route::post('/deleteQuestion', [App\Http\Controllers\Admin\AdminController::class, 'deleteQuestion'])->name('deleteQuestion');
  Route::post('/updateQuestion', [App\Http\Controllers\Admin\AdminController::class, 'updateQuestion'])->name('updateQuestion');
  Route::post('/addOption', [App\Http\Controllers\Admin\AdminController::class, 'addOption'])->name('addOption');

  Route::post('/addOption', [App\Http\Controllers\Admin\AdminController::class, 'addOption'])->name('addOption');
  Route::post('/examStatus', [App\Http\Controllers\Admin\AdminController::class, 'examStatus'])->name('examStatus');

  Route::get('/media', [App\Http\Controllers\Admin\AdminController::class, 'media']);
  Route::post('/addMedia', [App\Http\Controllers\Admin\AdminController::class, 'addMedia'])->name('addMedia');
  Route::post('/updateMedia', [App\Http\Controllers\Admin\AdminController::class, 'updateMedia'])->name('updateMedia');
  Route::post('/deleteMedia', [App\Http\Controllers\Admin\AdminController::class, 'deleteMedia'])->name('deleteMedia');

  Route::get('/admins', [App\Http\Controllers\Admin\AdminController::class, 'admins'])->name('admins');
  Route::post('/addAdmin', [App\Http\Controllers\Admin\AdminController::class, 'addAdmin'])->name('addAdmin');
  Route::post('/updateAdmin', [App\Http\Controllers\Admin\AdminController::class, 'updateAdmin'])->name('updateAdmin');
  Route::post('/deleteAdmin', [App\Http\Controllers\Admin\AdminController::class, 'deleteAdmin'])->name('deleteAdmin');


  Route::post('/clearCandidates', [App\Http\Controllers\Admin\AdminController::class, 'clearCandidates'])->name('clearCandidates');

});

Route::group(['prefix' => 'student'], function () {
  Route::get('/login', [App\Http\Controllers\Student\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\Student\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\Student\Auth\LoginController::class, 'logout'])->name('logout');

  
  Route::post('/password/email', [App\Http\Controllers\Student\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\Student\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\Student\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\Student\Auth\ResetPasswordController::class, 'showResetForm']);

});

Route::group(['prefix' => 'cbt'], function () {
  Route::get('/exams', [App\Http\Controllers\CBT\HomeController::class, 'index']);
  Route::get('/takeExam/{slug}', [App\Http\Controllers\CBT\HomeController::class, 'takeExam']);

  Route::post('/startExam', [App\Http\Controllers\CBT\HomeController::class, 'startExam'])->name('startExam');
  Route::post('/saveOption', [App\Http\Controllers\CBT\HomeController::class, 'saveOption'])->name('saveOption');
  Route::post('/forceSubmit', [App\Http\Controllers\CBT\HomeController::class, 'forceSubmit'])->name('forceSubmit');
  Route::post('/submitExam', [App\Http\Controllers\CBT\HomeController::class, 'submitExam'])->name('submitExam');

});

Route::get('/', [App\Http\Controllers\CBT\WelcomeController::class, 'welcome']);
