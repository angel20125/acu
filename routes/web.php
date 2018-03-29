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
Route::get('perfil/cambiar_rol/{rol}', 'ProfileController@changeRol')->middleware("logged")->name('change_rol');

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
Route::get('admin/usuarios/personificar/{user_id}', 'Admin\UsersController@impersonate')->middleware("logged")->middleware(['role:admin'])->name('user_impersonate');
Route::get('admin/usuarios/regenerar', 'Admin\UsersController@regenerate')->middleware("logged")->name('user_regenerate');

//Admin - Agenda
Route::get('admin/agendas', 'DiaryController@getIndex')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries');
Route::get('admin/agendas/obtener', 'DiaryController@getList')->middleware("logged")->middleware(['role:admin'])->name('get_admin_diaries');
Route::get('admin/agendas/registrar', 'DiaryController@getCreate')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_create');
Route::post('admin/agendas/registrar', 'DiaryController@create')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_create');
Route::get('admin/agendas/editar/{diary_id}', 'DiaryController@getEdit')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_edit');
Route::post('admin/agendas/editar', 'DiaryController@update')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_update');
Route::get('admin/agendas/eliminar/{diary_id}', 'DiaryController@getTrash')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_trash');
Route::post('admin/agendas/eliminar', 'DiaryController@delete')->middleware("logged")->middleware(['role:admin'])->name('admin_diaries_delete');

//Presidente
Route::get('presidente/inicio', 'ProfileController@getPresidentDashboard')->middleware("logged")->middleware(['role:presidente'])->name('presidente_dashboard');
Route::get('presidente/agendas/registrar', 'DiaryController@getCreate')->middleware("logged")->middleware(['role:presidente'])->name('presidente_diaries_create');
Route::post('presidente/agendas/registrar', 'DiaryController@create')->middleware("logged")->middleware(['role:presidente'])->name('presidente_diaries_create');
Route::get('presidente/puntos_propuestos', 'DiaryController@getPoints')->middleware("logged")->middleware(['role:presidente'])->name('get_presidente_points');
Route::get('presidente/puntos_propuestos/evaluar/{point_id}/{evaluation}', 'DiaryController@evaluatePoint')->middleware("logged")->middleware(['role:presidente'])->name('evaluate_presidente_points');
Route::get('presidente/historial/puntos_incluidos', 'DiaryController@getPresidentHistoryPoints')->middleware("logged")->middleware(['role:presidente'])->name('president_history_points');
Route::get('presidente/agregar_puntos', 'DiaryController@getPresidenteProposePoints')->middleware("logged")->middleware(['role:presidente'])->name('presidente_propose_points');
Route::post('presidente/agregar_puntos', 'DiaryController@PresidenteProposePoints')->middleware("logged")->middleware(['role:presidente'])->name('presidente_propose_points');

//Secretaria
Route::get('secretaria/inicio', 'ProfileController@getSecretariaDashboard')->middleware("logged")->middleware(['role:secretaria'])->name('secretaria_dashboard');
Route::get('secretaria/proponer_puntos', 'DiaryController@getSecretaryProposePoints')->middleware("logged")->middleware(['role:secretaria'])->name('secretaria_propose_points');
Route::get('secretaria/proponer_puntos/obtener/{user_id}', 'DiaryController@getListSelectSecretary')->middleware("logged")->middleware(['role:secretaria'])->name('get_diary_select');
Route::post('secretaria/proponer_puntos', 'DiaryController@SecretaryProposePoints')->middleware("logged")->middleware(['role:secretaria'])->name('secretaria_propose_points');

//Consejero
Route::get('consejero/inicio', 'ProfileController@getConsejeroDashboard')->middleware("logged")->middleware(['role:consejero'])->name('consejero_dashboard');
Route::get('consejero/proponer_puntos', 'DiaryController@getConsejeroProposePoints')->middleware("logged")->middleware(['role:consejero'])->name('consejero_propose_points');
Route::post('consejero/proponer_puntos', 'DiaryController@ConsejeroProposePoints')->middleware("logged")->middleware(['role:consejero'])->name('consejero_propose_points');
Route::get('consejero/historial/puntos_propuestos', 'DiaryController@getHistoryPoints')->middleware("logged")->middleware(['role:consejero'])->name('consejero_history_points');

//Adjunto
Route::get('adjunto/inicio', 'ProfileController@getAdjuntoDashboard')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_dashboard');
Route::get('adjunto/agendas', 'DiaryController@getAdjuntoIndex')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_diaries');
Route::get('adjunto/agendas/obtener', 'DiaryController@getListAdjunto')->middleware("logged")->middleware(['role:adjunto'])->name('get_adjunto_diaries');
Route::get('adjunto/agendas/finalizar/{diary_id}', 'DiaryController@getDiaryAdjunto')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_diaries_edit');
Route::post('adjunto/agendas/finalizar', 'DiaryController@diaryUpdate')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_diary_update');
Route::get('adjunto/agregar_puntos', 'DiaryController@getAdjuntoProposePoints')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_propose_points');
Route::post('adjunto/agregar_puntos', 'DiaryController@AdjuntoProposePoints')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_propose_points');
Route::get('adjunto/historial/puntos_incluidos', 'DiaryController@getPresidentHistoryPoints')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_history_points');
Route::get('adjunto/agendas/registrar', 'DiaryController@getCreate')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_diaries_create');
Route::post('adjunto/agendas/registrar', 'DiaryController@create')->middleware("logged")->middleware(['role:adjunto'])->name('adjunto_diaries_create');

// Routes accessible to other roles
Route::get('consejos', 'CouncilsController@getIndex')->middleware("logged")->name('councils');
Route::get('consejos/obtener', 'CouncilsController@getList')->middleware("logged")->name('get_councils');
Route::get('consejos/visualizar/{council_id}', 'CouncilsController@getCouncil')->middleware("logged")->name('get_council');
Route::get('consejos/visualizar/{council_id}/usuarios/', 'CouncilsController@getListMembers')->middleware("logged")->name('get_list_members');

Route::get('agendas', 'DiaryController@getLimitedIndex')->middleware("logged")->name('diaries');
Route::get('agendas/obtener', 'DiaryController@getListLimited')->middleware("logged")->name('get_diaries');
Route::get('agendas/visualizar/{diary_id}', 'DiaryController@getDiary')->middleware("logged")->name('get_diary');

Route::get('usuarios', 'UsersController@getIndex')->middleware("logged")->name('users');
Route::get('usuarios/obtener', 'UsersController@getList')->middleware("logged")->name('get_users');
Route::get('punto/borrar/{point_id}', 'DiaryController@deletePoint')->middleware("logged")->name('delete_point');
