<?php
Route::group(array('before'=>'guest'),function(){
  
  Route::get('/', array(
    'as' => 'index',
    'uses' => 'HomeController@index'
  ));

});

///////////////////////// Login
//Procesa el formulario e identifica al usuario
Route::post('/login', ['uses' => 'AuthController@doLogin', 'before' => 'guest']);

Route::filter('auth', function() {
    if (Auth::guest()) return Redirect::guest('index')->with('msg', 'Debes identificarte primero.');
});

//Página oculta donde sólo puede ingresar un usuario identificado
Route::group(array('before'=>'auth'),function(){
  

  /*
  * Ingresar al Panel Principal
  */
  Route::get('dashboard', array(
    'as' => 'dashboard',
    'uses' => 'HomeController@dashboard'
  ));

  /*
  * Salir del Sistema
  */
  Route::get('logout', array(
    'as' => 'logout',
    'uses' => 'AuthController@doLogout',
    'before' => 'auth'
  ));

  /*
  * Cambiar el Password (GET)
  */
  Route::get('password/change-password', array(
    'as' => 'password-change-password',
    'uses' => 'RemindersController@getChangePassword'
  ));

  Route::group(array('before'=>'csrf'),function(){
    /*
    * Cambiar el Password (POST)
    */
    Route::post('password/change-password', array(
      'as' => 'password-change-password-post',
      'uses' => 'RemindersController@postChangePassword'
    ));
  });
  
});


///////////////////////// Password Reminder

Route::get('password/remind', array(
    'as' => 'password.remind',
    'uses' => 'RemindersController@getRemind'
  ));

Route::get('password/recover/{codigo}', array(
    'as' => 'password.recover',
    'uses' => 'RemindersController@getRecover'
  ));

Route::group(array('before'=>'csrf'),function(){
  Route::post('password/remind', array(
    'as' => 'password.remind.post',
    'uses' => 'RemindersController@postRemind'
  ));
});
///////////////////////// Usuarios

/* BEGIN SOLAPAS */

Route::get('usuarios/solapas', array(
   'as' => 'usuarios.solapas',
   'uses' => 'UsuariosController@solapas'
 ));

Route::get('usuarios/solapas_mod/{id}', array(
    'as' => 'usuarios.solapas_mod',
    'uses' => 'UsuariosController@solapas_mod'
  ));

Route::get('itemnoajax', array(
    'as' => 'itemnoajax',
    'uses' => 'Usuariosontroller@getIndexNoAjax'
));

Route::get('usuarios/ajax/{type}', array(
    'as' => 'usuarios.type',
    'uses' => 'UsuariosController@getItemType'
))->where('type', 'titular|grupo_familiar');

/* END SOLAPAS*/

Route::get('usuarios/index', array(
    'as' => 'usuarios.index',
    'uses' => 'UsuariosController@index'
  ));

Route::post('usuarios/buscar', array(
    'as' => 'usuarios.buscar',
    'uses' => 'UsuariosController@buscar'
  ));

Route::get('usuarios/resultados/{datos}', array(
    'as' => 'usuarios.resultados',
    'uses' => 'UsuariosController@resultados'
  ));

Route::get('usuarios/crear', array(
    'as' => 'usuarios.crear',
    'uses' => 'UsuariosController@crear'
  ));

Route::get('usuarios/modificar/{id}', array(
    'as' => 'usuarios.modificar',
    'uses' => 'UsuariosController@modificar'
  ));

Route::get('usuarios/eliminar/{id}', array(
    'as' => 'usuarios.eliminar',
    'uses' => 'UsuariosController@eliminar'
  ));

//grupo de rutas que aceptan peticiones post, protegemos de ataques csrf
Route::group(array('before'=>'csrf'),function()
{
  Route::post('usuarios/crear',           'UsuariosController@crear');
  Route::post('usuarios/modificar/{id}',  'UsuariosController@modificar');
  Route::post('usuarios/modificar_gf/{id}',  'UsuariosController@modificar_gf');
});


///////////////////////// Clientes

Route::get('clientes/index', array(
    'as' => 'clientes.index',
    'uses' => 'ClientesController@index'
  ));

Route::post('clientes/buscar', array(
    'as' => 'clientes.buscar',
    'uses' => 'ClientesController@buscar'
  ));

Route::get('clientes/resultados/{datos}', array(
    'as' => 'clientes.resultados',
    'uses' => 'ClientesController@resultados'
  ));

Route::get('clientes/crear', array(
    'as' => 'clientes.crear',
    'uses' => 'ClientesController@crear'
  ));

Route::get('clientes/modificar/{id}', array(
    'as' => 'clientes.modificar',
    'uses' => 'ClientesController@modificar'
  ));

Route::get('clientes/eliminar/{id}', array(
    'as' => 'clientes.eliminar',
    'uses' => 'ClientesController@eliminar'
  ));

Route::group(array('before'=>'csrf'),function()
{
  Route::post('clientes/crear',           'ClientesController@crear');
  Route::post('clientes/modificar/{id}',  'ClientesController@modificar');
});

///////////////////////// Agenda

Route::get('agendas/index', array(
    'as' => 'agendas.index',
    'uses' => 'AgendasController@index'
  ));

Route::post('agendas/buscar', array(
    'as' => 'agendas.buscar',
    'uses' => 'AgendasController@buscar'
  ));

Route::get('agendas/resultados/{datos}', array(
    'as' => 'agendas.resultados',
    'uses' => 'AgendasController@resultados'
  ));

Route::get('agendas/crear', array(
    'as' => 'agendas.crear',
    'uses' => 'AgendasController@crear'
  ));

Route::get('agendas/modificar/{id}', array(
    'as' => 'agendas.modificar',
    'uses' => 'AgendasController@modificar'
  ));

Route::get('agendas/eliminar/{id}', array(
    'as' => 'agendas.eliminar',
    'uses' => 'AgendasController@eliminar'
  ));

Route::group(array('before'=>'csrf'),function()
{
  Route::post('agendas/crear',           'AgendasController@crear');
  Route::post('agendas/modificar/{id}',  'AgendasController@modificar');
});

///////////////////////// Expedientes

Route::get('expedientes/index', array(
    'as' => 'expedientes.index',
    'uses' => 'ExpedientesController@index'
  ));

Route::post('expedientes/buscar', array(
    'as' => 'expedientes.buscar',
    'uses' => 'ExpedientesController@buscar'
  ));

Route::get('expedientes/resultados/{datos}', array(
    'as' => 'expedientes.resultados',
    'uses' => 'ExpedientesController@resultados'
  ));

Route::get('expedientes/crear', array(
    'as' => 'expedientes.crear',
    'uses' => 'ExpedientesController@crear'
  ));

Route::get('expedientes/modificar/{id}', array(
    'as' => 'expedientes.modificar',
    'uses' => 'ExpedientesController@modificar'
  ));

Route::get('expedientes/eliminar/{id}', array(
    'as' => 'expedientes.eliminar',
    'uses' => 'ExpedientesController@eliminar'
  ));

Route::group(array('before'=>'csrf'),function()
{
  Route::post('expedientes/crear',           'ExpedientesController@crear');
  Route::post('expedientes/modificar/{id}',  'ExpedientesController@modificar');
});

///////////////////////// Escritos

Route::get('escritos/index', array(
    'as' => 'escritos.index',
    'uses' => 'EscritosController@index'
  ));

Route::post('escritos/buscar', array(
    'as' => 'escritos.buscar',
    'uses' => 'EscritosController@buscar'
  ));

Route::get('escritos/resultados/{datos}', array(
    'as' => 'escritos.resultados',
    'uses' => 'EscritosController@resultados'
  ));

Route::get('escritos/crear', array(
    'as' => 'escritos.crear',
    'uses' => 'EscritosController@crear'
  ));

Route::get('escritos/modificar/{id}', array(
    'as' => 'escritos.modificar',
    'uses' => 'EscritosController@modificar'
  ));

Route::get('escritos/eliminar/{id}', array(
    'as' => 'escritos.eliminar',
    'uses' => 'EscritosController@eliminar'
  ));

Route::group(array('before'=>'csrf'),function()
{
  Route::post('escritos/crear',           'EscritosController@crear');
  Route::post('escritos/modificar/{id}',  'EscritosController@modificar');
});

///////////////////////// Modelos


Route::get('modelos/index', array(
    'as' => 'modelos.index',
    'uses' => 'ModelosController@index'
  ));

Route::post('modelos/buscar', array(
    'as' => 'modelos.buscar',
    'uses' => 'ModelosController@buscar'
  ));

Route::get('modelos/resultados/{datos}', array(
    'as' => 'modelos.resultados',
    'uses' => 'ModelosController@resultados'
  ));

Route::get('modelos/crear', array(
    'as' => 'modelos.crear',
    'uses' => 'ModelosController@crear'
  ));

Route::get('modelos/modificar/{id}', array(
    'as' => 'modelos.modificar',
    'uses' => 'ModelosController@modificar'
  ));

Route::get('modelos/eliminar/{id}', array(
    'as' => 'modelos.eliminar',
    'uses' => 'ModelosController@eliminar'
  ));

Route::group(array('before'=>'csrf'),function()
{
  Route::post('modelos/crear',           'ModelosController@crear');
  Route::post('modelos/modificar/{id}',  'ModelosController@modificar');
});

///////////////////////// Pagos

Route::get('pagos/index', array(
    'as' => 'pagos.index',
    'uses' => 'PagosController@index'
  ));

Route::post('pagos/buscar', array(
    'as' => 'pagos.buscar',
    'uses' => 'PagosController@buscar'
  ));

Route::get('pagos/resultados/{datos}', array(
    'as' => 'pagos.resultados',
    'uses' => 'PagosController@resultados'
  ));

Route::get('pagos/crear', array(
    'as' => 'pagos.crear',
    'uses' => 'PagosController@crear'
  ));

Route::group(array('before'=>'csrf'),function()
{
  Route::post('pagos/crear', 'PagosController@crear');
});

///////////////////////// Backups

Route::get('backups/index', array(
    'as' => 'backups.index',
    'uses' => 'BackupsController@index'
  ));

Route::post('backups/buscar', array(
    'as' => 'backups.buscar',
    'uses' => 'BackupsController@buscar'
  ));

Route::get('backups/resultados/{datos}', array(
    'as' => 'backups.resultados',
    'uses' => 'BackupsController@resultados'
  ));

Route::get('backups/crear_dbase', array(
    'as' => 'backups.crear_dbase',
    'uses' => 'BackupsController@crear_dbase'
  ));

Route::get('backups/{file}', 'BackupsController@getDownloadFile');

Route::group(array('before'=>'csrf'),function()
{
  Route::post('backups/crear_dbase', 'BackupsController@crear_dbase');
});

///////////////////////// Listados

Route::get('listados/index', array(
    'as' => 'listados.index',
    'uses' => 'ListadosController@index'
  ));

Route::post('listados/buscar', array(
    'as' => 'listados.buscar',
    'uses' => 'ListadosController@buscar'
  ));

// Route::get('listados/exportar', 'ListadosController@exportar');

Route::post('listados/exportar', array(
    'as' => 'listados.exportar',
    'uses' => 'ListadosController@exportar'
  ));