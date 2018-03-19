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

Route::get('/', 'HomeController@index')->name('home');
Route::get('dashboard', 'ProfileController@getDashboard')->middleware("logged")->name('dashboard');

//Authentication Routes
Route::get('login', 'ProfileController@getLogin')->name('login');
Route::post('login', 'ProfileController@postLogin')->name('post_login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'ProfileController@getResetPassword')->name("password_reset");
Route::post('password/email', 'ProfileController@sendResetLinkEmail')->name("post_password_reset");
Route::get('password/reset/{token}', 'ProfileController@getResetPasswordToken')->name("password_reset_token");
Route::post('password/reset', 'ProfileController@resetPassword')->name("post_password_reset_token");

//Admin - Council
Route::get('admin/councils', 'Admin\CouncilsController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_councils');
Route::get('admin/councils/get', 'Admin\CouncilsController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_councils');
Route::get('admin/councils/create', 'Admin\CouncilsController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_create');
Route::post('admin/councils/create', 'Admin\CouncilsController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_create');
Route::get('admin/councils/edit/{council_id}', 'Admin\CouncilsController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_edit');
Route::post('admin/councils/edit', 'Admin\CouncilsController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_update');
Route::get('admin/councils/trash/{council_id}', 'Admin\CouncilsController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_trash');
Route::post('admin/councils/delete', 'Admin\CouncilsController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_delete');

//Admin - Users
Route::get('admin/users', 'Admin\UsersController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_users');
Route::get('admin/users/get', 'Admin\UsersController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_users');
Route::get('admin/users/create', 'Admin\UsersController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_users_create');
Route::post('admin/users/create', 'Admin\UsersController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_users_create');
Route::get('admin/users/edit/{user_id}', 'Admin\UsersController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_users_edit');
Route::post('admin/users/edit', 'Admin\UsersController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_users_update');
Route::get('admin/users/trash/{user_id}', 'Admin\UsersController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_users_trash');
Route::post('admin/users/delete', 'Admin\UsersController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_users_delete');

//Agenda
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function() {

    Route::group([
        'prefix' => 'agenda',
    ], function() {
        Route::get('', 'AgendaController@index');
        Route::get('{id}','AgendaController@show');
        Route::get('create', 'AgendaController@create');
        Route::post('create', 'AgendaController@store');
        Route::post('update/{agenda_id}', 'AgendaController@update');
        Route::delete('delete/{agenda_id}', 'AgendaController@delete');
    });

});

