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

//Authentication Routes...
Route::get('login', 'ProfileController@getLogin')->name('login');
Route::post('login', 'ProfileController@postLogin')->name('post_login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//Admin - Council
Route::get('admin/councils', 'Admin\CouncilsController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_councils');
Route::get('admin/councils/get', 'Admin\CouncilsController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_councils');
Route::get('admin/councils/create', 'Admin\CouncilsController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_create');
Route::post('admin/councils/create', 'Admin\CouncilsController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_create');
Route::get('admin/councils/edit/{council_id}', 'Admin\CouncilsController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_edit');
Route::post('admin/councils/edit', 'Admin\CouncilsController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_update');
Route::get('admin/councils/trash/{council_id}', 'Admin\CouncilsController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_trash');
Route::post('admin/councils/delete', 'Admin\CouncilsController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_delete');