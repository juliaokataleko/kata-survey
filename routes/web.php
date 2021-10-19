<?php

use App\Http\Controllers\PlaySurveyController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyOptionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::group(
    ['middleware' => 'auth'],
    function () {

        Route::resource('surveys', SurveyController::class);
        Route::resource('survey-options', SurveyOptionController::class);
    }
);

Route::resource('play-surveys', PlaySurveyController::class);

Route::any('{any}', function () {
    return view('home');
})->where('any', '.*');
