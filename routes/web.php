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

  Route::get('/students', [App\Http\Controllers\Admin\AdminController::class, 'students'])->name('students');
  Route::post('/addSingleStudent', [App\Http\Controllers\Admin\AdminController::class, 'addSingleStudent'])->name('addSingleStudent');
  Route::post('/addBulkStudent', [App\Http\Controllers\Admin\AdminController::class, 'addBulkStudent'])->name('addBulkStudent');
  Route::post('/updateStudent', [App\Http\Controllers\Admin\AdminController::class, 'updateStudent'])->name('updateStudent');
  Route::post('/deleteStudent', [App\Http\Controllers\Admin\AdminController::class, 'deleteStudent'])->name('deleteStudent');

  Route::post('/addSingleCandidate', [App\Http\Controllers\Admin\AdminController::class, 'addSingleCandidate'])->name('addSingleCandidate');
  Route::post('/addBulkCandidate', [App\Http\Controllers\Admin\AdminController::class, 'addBulkCandidate'])->name('addBulkCandidate');
  Route::post('/deleteCandidate', [App\Http\Controllers\Admin\AdminController::class, 'deleteCandidate'])->name('deleteCandidate');
  

  Route::post('/uploadBulkQuestion', [App\Http\Controllers\Admin\AdminController::class, 'uploadBulkQuestion'])->name('uploadBulkQuestion');
  Route::post('/deleteOption', [App\Http\Controllers\Admin\AdminController::class, 'deleteOption'])->name('deleteOption');
  Route::post('/updateOption', [App\Http\Controllers\Admin\AdminController::class, 'updateOption'])->name('updateOption');
  Route::post('/deleteQuestion', [App\Http\Controllers\Admin\AdminController::class, 'deleteQuestion'])->name('deleteQuestion');
  Route::post('/updateQuestion', [App\Http\Controllers\Admin\AdminController::class, 'updateQuestion'])->name('updateQuestion');
  Route::post('/addOption', [App\Http\Controllers\Admin\AdminController::class, 'addOption'])->name('addOption');

  Route::post('/addOption', [App\Http\Controllers\Admin\AdminController::class, 'addOption'])->name('addOption');

});
