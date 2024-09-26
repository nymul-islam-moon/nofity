<?php

use App\Http\Controllers\Frontend\FrontendController;
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

/**
 * This Auth is using for admin section
 */
Auth::routes();

Route::prefix('/')->group(function () {
    Route::controller(FrontendController::class)->group(function () {
        Route::get('/login', 'login')->name('frontend.student.login');
        Route::post('/login/submit', 'login_store')->name('frontend.login.submit');
        Route::post('/registration/store', 'registration_store')->name('frontend.registration.submit');
        Route::get('/logout', 'logout')->name('frontend.student.logout');
        Route::get('/registration', 'registration')->name('frontend.student.registration');
        Route::get('/student/verify/{token}', 'verifyStudent')->name('frontend.student.verify');
        Route::get('/', 'important')->name('frontend.student.index');
        // Route::get('/show/{notification}', 'show')->name('frontend.student.show')->middleware('student');
        // Route::get('/tags', 'tags')->name('frontend.student.tags')->middleware('student');
        // Route::get('/important', 'important')->name('frontend.student.important')->middleware('student');
        // Route::post('/{favoriteTagId}/store', 'storeFavoriteTag')->name('store.favorite.tag');
        // Route::post('/{favoriteTagId}/remove', 'removeFavoriteTag')->name('remove.favorite.tag');
        // Route::get('/favorite/notifications', 'favoriteNotifications')->name('frontend.favorite.notification')->middleware('student');
        Route::get('/profile', 'profile')->name('frontend.profile.index')->middleware('student');
        Route::post('/update/profile', 'profile_update')->name('frontend.profile.update')->middleware('student');
        Route::post('/update/password', 'password_update')->name('frontend.profile.password')->middleware('student');

        // SteadFast
        Route::get('/short_url', 'short_url')->name('frontend.shortUrl.index')->middleware('student');
        Route::post('/short_url/store', 'store_short_url')->name('frontend.shortUrl.store')->middleware('student');
        Route::get('/{shortUrl}/destroy', 'destroy_url')->name('destroy.shortUrl')->middleware('student');
        Route::get('/{shortUrl}', 'redirect_url')->name('redirect_url');
    });

});
