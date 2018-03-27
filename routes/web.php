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
Route::get('inicio', 'ProfileController@getDashboard')->middleware('logged')->name('dashboard');

//Profile Controller
Route::get('perfil', 'ProfileController@getProfile')->middleware('logged')->name('profile');
Route::post('perfil/editar', 'ProfileController@saveProfile')->middleware('logged')->name('save_profile');

//Authentication Routes
Route::get('verify/{code}', 'ProfileController@verify')->name('verify');
Route::get('login', 'ProfileController@getLogin')->name('login');
Route::post('login', 'ProfileController@postLogin')->name('post_login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes
Route::get('password/reset', 'ProfileController@getResetPassword')->name("password_reset");
Route::post('password/email', 'ProfileController@sendResetLinkEmail')->name("post_password_reset");
Route::get('password/reset/{token}', 'ProfileController@getResetPasswordToken')->name("password_reset_token");
Route::post('password/reset', 'ProfileController@resetPassword')->name("post_password_reset_token");

//Admin - Dashboard
Route::get('admin/inicio', 'Admin\AdminController@getAdminDashboard')->middleware("logged")->middleware(['role:admin'])->name('admin_dashboard');

//Admin - Cargos
Route::get('admin/cargos', 'Admin\PositionsController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_positions');
Route::get('admin/cargos/obtener', 'Admin\PositionsController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_positions');
Route::get('admin/cargos/registrar', 'Admin\PositionsController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_positions_create');
Route::post('admin/cargos/registrar', 'Admin\PositionsController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_positions_create');
Route::get('admin/cargos/editar/{council_id}', 'Admin\PositionsController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_positions_edit');
Route::post('admin/cargos/editar', 'Admin\PositionsController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_positions_update');
Route::get('admin/cargos/eliminar/{council_id}', 'Admin\PositionsController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_positions_trash');
Route::post('admin/cargos/eliminar', 'Admin\PositionsController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_positions_delete');

//Admin - Council
Route::get('admin/consejos', 'Admin\CouncilsController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_councils');
Route::get('admin/consejos/obtener', 'Admin\CouncilsController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_councils');
Route::get('admin/consejos/registrar', 'Admin\CouncilsController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_create');
Route::post('admin/consejos/registrar', 'Admin\CouncilsController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_create');
Route::get('admin/consejos/editar/{council_id}', 'Admin\CouncilsController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_edit');
Route::post('admin/consejos/editar', 'Admin\CouncilsController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_update');
Route::get('admin/consejos/eliminar/{council_id}', 'Admin\CouncilsController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_trash');
Route::post('admin/consejos/eliminar', 'Admin\CouncilsController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_councils_delete');

//Admin - Users
Route::get('admin/usuarios', 'Admin\UsersController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_users');
Route::get('admin/usuarios/obtener', 'Admin\UsersController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_users');
Route::get('admin/usuarios/registrar', 'Admin\UsersController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_users_create');
Route::post('admin/usuarios/registrar', 'Admin\UsersController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_users_create');
Route::get('admin/usuarios/editar/{user_id}', 'Admin\UsersController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_users_edit');
Route::post('admin/usuarios/editar', 'Admin\UsersController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_users_update');
Route::get('admin/usuarios/eliminar/{user_id}', 'Admin\UsersController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_users_trash');
Route::post('admin/usuarios/eliminar', 'Admin\UsersController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_users_delete');
Route::get('admin/usuarios/registrar_secretaria', 'Admin\UsersController@getCreateSecretary')->middleware("logged")->middleware(['role:admin'])->name('admin_users_create_secretary');
Route::post('admin/usuarios/registrar_secretaria', 'Admin\UsersController@createSecretary')->middleware("logged")->middleware(['role:admin'])->name('admin_users_create_secretary');

//Admin - Agenda
Route::get('admin/agendas', 'DiaryController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries');
Route::get('admin/agendas/obtener', 'DiaryController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_diaries');
Route::get('admin/agendas/registrar', 'DiaryController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_create');
Route::post('admin/agendas/registrar', 'DiaryController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_create');
Route::get('admin/agendas/editar/{diary_id}', 'DiaryController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_edit');
Route::post('admin/agendas/editar', 'DiaryController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_update');
Route::get('admin/agendas/eliminar/{diary_id}', 'DiaryController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_trash');
Route::post('admin/agendas/eliminar', 'DiaryController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_delete');

//Show agenda
Route::get('agendas/visualizar/{diary_id}', 'DiaryController@getDiary')->middleware("logged")->name('getDiary');