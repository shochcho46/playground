<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
Route::post('validate/login', [App\Http\Controllers\HomeController::class, 'validateLogin'])->name('loginCheck');
// Route::get('/logout', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register', [App\Http\Controllers\HomeController::class, 'registration'])->name('registration');
Route::post('store/register', [App\Http\Controllers\HomeController::class, 'storRegistration'])->name('storRegistration');

// socialite

Route::get('google/oauth/load', [App\Http\Controllers\HomeController::class, 'googleOauthLoad'])->name('googleOauthLoad');
Route::get('google/auth/callback', [App\Http\Controllers\HomeController::class, 'googleOauthCallBack'])->name('googleOauthCallBack');




Route::prefix('user')->group(function () {

    Route::middleware(['auth'])->group(function () {

        Route::controller(HomeController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('user.dashboard');
            Route::get('logout', 'logout')->name('user.logout');
        //     Route::post('store', 'store');
        //     Route::post('update/{survey:uuid}', 'update');
        //     Route::get('show/{survey:uuid}', 'show');
        //     Route::get('cheak/status/{survey:uuid}', 'cheakStatus');
        });

    });

    // Route::get('user/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('user.dashboard');
    Route::prefix('surveys')->group(function () {

        // Route::controller(HomeController::class)->group(function () {
        //     Route::get('list', 'index');
        //     Route::post('store', 'store');
        //     Route::post('update/{survey:uuid}', 'update');
        //     Route::get('show/{survey:uuid}', 'show');
        //     Route::get('cheak/status/{survey:uuid}', 'cheakStatus');
        // });
    });

    // Route::prefix('question')->group(function () {
    //     Route::controller(QuestionController::class)->group(function () {
    //         Route::get('list/', 'index');
    //         Route::post('store', 'store');
    //         Route::post('update/{question}', 'update');
    //         Route::get('show/{question}', 'show');
    //         Route::post('delete/{question}', 'destroy');

    //     });
    // });

    // Route::prefix('option')->group(function () {
    //     Route::controller(QuestionOptionController::class)->group(function () {
    //         Route::get('list/', 'index');
    //         Route::post('store', 'store');
    //         Route::post('update/{questionOption}', 'update');
    //         Route::get('show/{questionOption}', 'show');
    //         Route::post('delete/{questionOption}', 'destroy');

    //     });
    // });


    // Route::prefix('participant')->group(function () {
    //     Route::controller(SurveyParticipantController::class)->group(function () {
    //         Route::post('store', 'store');
    //         Route::get('list/', 'index');
    //         Route::post('update/{questionOption}', 'update');
    //         Route::get('show/{questionOption}', 'show');
    //         Route::post('delete/{questionOption}', 'destroy');

    //     });
    // });

    // Route::prefix('participant/answer')->group(function () {
    //     Route::controller(ParticipantAnswerController::class)->group(function () {
    //         Route::post('store', 'store');
    //         Route::get('list/', 'index');
    //         Route::post('update/{questionOption}', 'update');
    //         Route::get('show/{questionOption}', 'show');
    //         Route::post('delete/{questionOption}', 'destroy');

    //     });
    // });

    // Route::prefix('graph')->group(function () {
    //     Route::controller(SurveyGraph::class)->group(function () {

    //         Route::get('participant/{survey:uuid}', 'participantGraph');
    //         Route::get('question/{survey:uuid}', 'questionGraph');


    //     });
    // });

});
