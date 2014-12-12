<?php


Route::group(array('before'=>'guest'),function(){

  /* 
  * Ingresar al Home (GET)
  */
  Route::get('/', array(
    'as' => 'index',
    'uses' => 'HomeController@index'
  ));

  /* 
  * Ingresar a Olvidé mi contraseña (GET)
  */
  Route::get('password/remind', array(
    'as' => 'password.remind',
    'uses' => 'RemindersController@getRemind'
  ));

  /* 
  * Ejecutar el envío de la contraseña (GET)
  */
  Route::get('password/recover/{codigo}', array(
    'as' => 'password.recover',
    'uses' => 'RemindersController@getRecover'
  ));

  
  Route::group(array('before'=>'csrf'),function(){
    /* 
    * Procesar el envío de la contraseña (POST)
    */
    Route::post('password/remind', array(
      'as' => 'password.remind.post',
      'uses' => 'RemindersController@postRemind'
    ));
  });

});



///////////////////////// Login
//Procesa el formulario e identifica al usuario
Route::post('/login', ['uses' => 'AuthController@doLogin', 'before' => 'guest']);



//Página oculta donde sólo puede ingresar un usuario identificado
Route::group(array('before'=>'auth'), function(){

  /*
  * Ingresar al Panel Principal (GET)
  */
  Route::get('dashboard', array(
    'as' => 'dashboard',
    'uses' => 'HomeController@dashboard'
  ));

  /*
  * Salir del Sistema (GET)
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

  Route::group(array('before'=>'csrf'), function(){
    /*
    * Cambiar el Password (POST)
    */
    Route::post('password/change-password', array(
      'as' => 'password-change-password-post',
      'uses' => 'RemindersController@postChangePassword'
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

  Route::get('usuarios/eliminar_gf/{gf_id}/{id}', array(
      'as' => 'usuarios.eliminar_gf',
      'uses' => 'UsuariosController@eliminar_gf'
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

  Route::get('expedientes/imprimir/{id}', array(
      'as' => 'expedientes.imprimir',
      'uses' => 'ExpedientesController@imprimir'
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

  Route::get('escritos/index/{id}', array(
      'as' => 'escritos.index',
      'uses' => 'EscritosController@index'
    ));

  Route::get('escritos/imprimir/{id}', array(
      'as' => 'escritos.imprimir',
      'uses' => 'EscritosController@imprimir'
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

  Route::get('escritos/crear_desde_modelo', array(
      'as' => 'escritos.crear_desde_modelo',
      'uses' => 'EscritosController@crear_desde_modelo'
    ));

  Route::get('escritos/modificar/{id}', array(
      'as' => 'escritos.modificar',
      'uses' => 'EscritosController@modificar'
    ));

  Route::get('escritos/eliminar/{id}', array(
      'as' => 'escritos.eliminar',
      'uses' => 'EscritosController@eliminar'
    ));

  /* BEGIN Rutas Ajax para la generación de Escrito desde Modelo */
  Route::post('escritos/buscar_tipos_procesos', array(
      'as' => 'escritos.buscar_tipos_procesos',
      'uses' => 'EscritosController@buscar_tipos_procesos'
    ));

  Route::post('escritos/buscar_modelos_listado', array(
      'as' => 'escritos.buscar_modelos_listado',
      'uses' => 'EscritosController@buscar_modelos_listado'
    ));

  Route::post('escritos/buscar_modelo_codigos', array(
      'as' => 'escritos.buscar_modelo_codigos',
      'uses' => 'EscritosController@buscar_modelo_codigos'
    ));

  Route::post('escritos/generar_escrito_reemplazo_codigos', array(
      'as' => 'escritos.generar_escrito_reemplazo_codigos',
      'uses' => 'EscritosController@generar_escrito_reemplazo_codigos'
    ));

  Route::post('escritos/importar', array(
      'as' => 'escritos.importar',
      'uses' => 'EscritosController@importar'
    ));

  Route::post('escritos/importar_subir_archivo_windows', array(
      'as' => 'escritos.importar.subir_archivo_windows',
      'uses' => 'EscritosController@importar_subir_archivo_windows'
    ));

  Route::post('escritos/importar_escritos_listado', array(
      'as' => 'escritos.importar.importar_escritos_listado',
      'uses' => 'EscritosController@importar_escritos_listado'
    ));
  /* FIN Rutas Ajax para la generación de Escrito desde Modelo */

  Route::group(array('before'=>'csrf'),function()
  {
    Route::post('escritos/crear',               'EscritosController@crear');
    Route::post('escritos/modificar/{id}',      'EscritosController@modificar');
    Route::post('escritos/crear_desde_modelo',  'EscritosController@crear_desde_modelo');
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

  Route::get('modelos/vercodigos', array(
      'as' => 'modelos.vercodigos',
      'uses' => 'ModelosController@vercodigos'
    ));

  Route::post('modelos/buscarcodigos', array(
      'as' => 'modelos.buscarcodigos',
      'uses' => 'ModelosController@buscarcodigos'
    ));

  Route::get('modelos/resultadoscodigos/{datos}', array(
      'as' => 'modelos.resultadoscodigos',
      'uses' => 'ModelosController@resultadoscodigos'
    ));

  Route::group(array('before'=>'csrf'),function()
  {
    Route::post('modelos/crear',           'ModelosController@crear');
    Route::post('modelos/modificar/{id}',  'ModelosController@modificar');
  });

  ///////////////////////// Pagos

  Route::get('pagos/index/{id}', array(
      'as' => 'pagos.index',
      'uses' => 'PagosController@index'
    ));

  Route::get('pagos/imprimir/{id}', array(
      'as' => 'pagos.imprimir',
      'uses' => 'PagosController@imprimir'
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

  Route::get('backups/crear_dbase', array(
      'as' => 'backups.crear_dbase',
      'uses' => 'BackupsController@crear_dbase'
    ));

  Route::get('backups/{file}', 'BackupsController@getDownloadFile');

  Route::group(array('before'=>'csrf'),function()
  {
    Route::post('backups/crear_dbase_windows', 'BackupsController@crear_dbase_windows');
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
  
});