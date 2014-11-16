<?php

class ListadosController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){

      $tipos = array();

      return View::make('listado.index', array("datos" => $tipos));
    }
    else{
      return Redirect::route('index')
            ->withErrors(array('error' => 'Debe loguearse para poder usar la aplicación.'));
    }
  }

  public function buscar() 
  {
    $datos = false;
    $ingreso_algun_dato = false;
    $inputs = $this->getInputs(Input::all());

    foreach($inputs as $indice=>$valor){
      if($indice != '_token') {
        if($valor != ''){
          $datos .= $indice . "=" . $valor ."&";
          $ingreso_algun_dato = true;
        }
      }
    }

    if(!$ingreso_algun_dato) {
      return Redirect::route('listados.index');
    }

    // EMPLEADOS
    if($inputs['tipo_modulo'] === 'Empleados') {
      $datos = Usuario::where('parentesco','=','Titular')->orderBy('created_at','desc')->get();

      foreach($datos->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }

      $datos->tipo_modulo = 'Empleados';
    }

    // CLIENTES
    if($inputs['tipo_modulo'] === 'Clientes') {
      $datos = Cliente::orderBy('created_at','desc')->get();

      foreach($datos->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }

      $datos->tipo_modulo = 'Clientes';
    }

    // EXPEDIENTES
    if($inputs['tipo_modulo'] === 'Expedientes') {
      $datos = Expediente::join('clientes', 'expedientes.cliente_id', '=', 'clientes.id')
        ->where('clientes.estado', 'Activo')
        ->orderBy('expedientes.created_at','desc')->get();

      foreach($datos->all() as $dato) {
        $dato->fecha_inicio = $this->convertir_fecha_es($dato->fecha_inicio);
      }

      $datos->tipo_modulo = 'Expedientes';
    }

    return View::make('listado.index', array("datos" => $datos));
  }  

  //método privado para obtener los inputs del formulario
  private function getInputs($inputs = array()){
    foreach($inputs as $key => $val){
        $inputs[$key] = $val;
    }

    return $inputs;
  }

  private function convertir_fecha_us($fecha_es = '00-00-0000'){

    if(substr($fecha_es, 2, 1) === '-') {
      $ano = substr($fecha_es, 6, 4);
      $mes = substr($fecha_es, 3, 2);
      $dia = substr($fecha_es, 0, 2);

      $fecha_en = $ano . "-" . $mes . "-" .$dia; 

      return  $fecha_en;
    }
    else {
      return $fecha_es;
    }
  }

  private function convertir_fecha_es($fecha_en = '0000-00-00'){

    if(substr($fecha_en, 4, 1) === '-') {
      $ano = substr($fecha_en, 0, 4);
      $mes = substr($fecha_en, 5, 2);
      $dia = substr($fecha_en, 8, 2);

      if(strpos($fecha_en, ':') > 0){
        $hora = substr($fecha_en, 11, 8);
      }
      else{
        $hora = '';
      }

      $fecha_es = trim($dia . "-" . $mes . "-" .$ano . " " . $hora);

      return  $fecha_es;
    }
    else {
      return $fecha_en;
    }
  }

  public function exportar() {

    $inputs = $this->getInputs(Input::all());

    // EMPLEADOS
    if($inputs['tipo_modulo'] === 'Empleados') {
      $datos = Usuario::where('parentesco','=','Titular')->orderBy('created_at','desc')->get();

      $nombre_archivo = 'listado_usuarios';
      $nombre_sheet = 'Lista de Usuarios';
    }

    // CLIENTES
    if($inputs['tipo_modulo'] === 'Clientes') {
      $datos = Cliente::orderBy('created_at','desc')->get();

      $nombre_archivo = 'listado_clientes';
      $nombre_sheet = 'Lista de Clientes';
    }

    // EXPEDIENTES
    if($inputs['tipo_modulo'] === 'Expedientes') {
      $datos = Expediente::join('clientes', 'expedientes.cliente_id', '=', 'clientes.id')
        ->where('clientes.estado', 'Activo')
        ->orderBy('expedientes.created_at','desc')->get();

      $nombre_archivo = 'listado_expedientes';
      $nombre_sheet = 'Lista de Expedientes';
    }

    $headers = $this->getColumnNames($datos);
    $posts_array = array_merge((array)$datos->toArray());

    Excel::create($nombre_archivo)
      -> sheet($nombre_sheet)
      -> with($posts_array)
      -> export('xls');

    return Redirect::route('index')
      ->withErrors(array('mensaje' => 'La exportación se realizó correctamente.'));
  }

  public function getColumnNames($object) {

    $rip_headers = $object->toArray();

    $keys = array_keys($rip_headers[0]);

    foreach ($keys as $value) {
      $headers[$value] = $value;
    }

    return array($headers);
  }
}
