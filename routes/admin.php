<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\LoginController;



Route::get('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/login/store', [LoginController::class, 'login'])->name('admin.login.store');

Route::middleware(['canLogin'])->prefix('admin')->group(function () {

    Route::get('/home', [AdminController::class, 'admin'])->name('admin.home');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::controller(NotificationController::class)->prefix('notifications')->group(function () {
        Route::get('/', 'index')->name('faculty.notification.index');
        Route::get('/create', 'create')->name('faculty.notification.create');
        Route::post('/store', 'store')->name('faculty.notification.store');
        Route::get('/{notification}/edit', 'edit')->name('faculty.notification.edit');
        Route::put('/{notification}/update', 'update')->name('faculty.notification.update');
        Route::post('/{notification}/activate', 'activate')->name('faculty.notification.activate');
        Route::post('/{notification}/deactivate', 'deactivate')->name('faculty.notification.deactivate');
        Route::delete('/{notification}/softDelete', 'softDelete')->name('faculty.notification.delete');
        Route::post('/{notification}/restore', 'restore')->name('faculty.notification.restore');
        Route::delete('/{notification}/hard-delete', 'hardDelete')->name('faculty.notification.hard_delete');
        Route::delete('/soft/delete/all', 'softDeleteAll')->name('faculty.notification.softDeleteAll');
        Route::delete('/hard-delete-all', 'hardDeleteAll')->name('faculty.notification.hard_delete_all');
        Route::post('/restore/all', 'restoreAll')->name('faculty.notification.restore_all');
    });


    Route::controller(TagController::class)->prefix('tags')->group(function () {
        Route::get('/', 'index')->name('faculty.tag.index');
        Route::get('/create', 'create')->name('faculty.tag.create');
        Route::post('/store', 'store')->name('faculty.tag.store');
        Route::get('/{tag}/edit', 'edit')->name('faculty.tag.edit');
        Route::put('/{tag}/update', 'update')->name('faculty.tag.update');
        Route::post('/{tag}/activate', 'activate')->name('faculty.tag.activate');
        Route::post('/{tag}/deactivate', 'deactivate')->name('faculty.tag.deactivate');
        Route::delete('/{tag}/softDelete', 'softDelete')->name('faculty.tag.delete');
        Route::post('/{tag}/restore', 'restore')->name('faculty.tag.restore');
        Route::delete('/{tag}/hard-delete', 'hardDelete')->name('faculty.tag.hard_delete');
        Route::delete('/soft/delete/all', 'softDeleteAll')->name('faculty.tag.softDeleteAll');
        Route::delete('/hard-delete-all', 'hardDeleteAll')->name('faculty.tag.hard_delete_all');
        Route::post('/restore/all', 'restoreAll')->name('faculty.tag.restore_all');
    });

    Route::controller(UsersController::class)->prefix('faculty')->group(function () {
        Route::get('/', 'index')->name('admin.users.index');
        Route::get('/create', 'create')->name('admin.users.create');
        Route::post('/store', 'store')->name('admin.users.store');
        Route::get('/{users}/edit', 'edit')->name('admin.users.edit');
        Route::put('/{users}/update', 'update')->name('admin.users.update');
        Route::post('/{users}/active', 'active')->name('admin.users.active');
        Route::post('/{users}/de-active', 'deactive')->name('admin.users.deactive');
        Route::delete('/{users}/destroy', 'destroy')->name('admin.users.destroy');
        Route::post('/{users}/restore', 'restore')->name('admin.users.restore');
        Route::delete('/{users}/force-delete', 'forceDelete')->name('admin.users.forcedelete');
        Route::delete('/destroy-all', 'destroyAll')->name('admin.users.destroyAll');
        Route::delete('/permanent-destroy-all', 'permanentDestroyAll')->name('admin.users.permanentDestroyAll');
        Route::delete('/restore-all', 'restoreAll')->name('admin.users.restoreAll');
    });

    Route::controller(StudentController::class)->prefix('students')->group(function () {
        Route::get('/', 'index')->name('admin.students.index');
        Route::get('/create', 'create')->name('admin.students.create');
        Route::post('/store', 'store')->name('admin.students.store');
        Route::get('/{students}/edit', 'edit')->name('admin.students.edit');
        Route::put('/{students}/update', 'update')->name('admin.students.update');
        Route::post('/{students}/activate', 'activate')->name('admin.students.activate');
        Route::post('/{students}/deactivate', 'deactivate')->name('admin.students.deactivate');
        Route::delete('/{students}/softDelete', 'softDelete')->name('admin.students.delete');
        Route::post('/{students}/restore', 'restore')->name('admin.students.restore');
        Route::delete('/{students}/hard-delete', 'hardDelete')->name('admin.students.hard_delete');
        Route::delete('/soft/delete/all', 'softDeleteAll')->name('admin.students.softDeleteAll');
        Route::delete('/hard-delete-all', 'hardDeleteAll')->name('admin.students.hard_delete_all');
        Route::post('/restore/all', 'restoreAll')->name('admin.students.restore_all');
    });

    Route::controller(AdminProfileController::class)->prefix('profile')->group(function () {
        Route::get('/', 'index')->name('admin.profile.index');
    });



    Route::get('/test', function () {
        return view('admin.test.index');
    });

});
