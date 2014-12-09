<?php

class ModelosController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){
      $modelos  = Modelo::join('modelos_procesos_relacionados','modelos.id','=','modelos_procesos_relacionados.modelo_id')
        ->join('modelos_procesos','modelos_procesos.id','=','modelos_procesos_relacionados.modelos_proceso_id')
        ->select('modelos.nombre AS nombre_modelo','modelos_procesos.nombre AS nombre_tipo_proceso','modelos.id')
        ->orderBy('modelos.created_at','desc')->get();

      foreach($modelos->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }

      return View::make('modelo.index', array("datos" => $modelos));
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
      return Redirect::route('modelos.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('modelos.resultados', $datos);
  }  

  public function resultados($datos) 
  {
    $datos_array = explode('&', $datos);
    
    foreach($datos_array as $valor) {
      $subarray = explode('=', $valor);

      if($subarray[0] === 'created_at_desde'){
        $param[$subarray[0]] = $this->convertir_fecha_us($subarray[1]);
      }
      else if($subarray[0] === 'created_at_hasta'){
        $param[$subarray[0]] = $this->convertir_fecha_us($subarray[1]);
      }
      else {
        $param[$subarray[0]] = $subarray[1];
      }
    }

    $modelos  = $modelos  = Modelo::BuscarFiltros($param)
      ->join('modelos_procesos_relacionados','modelos.id','=','modelos_procesos_relacionados.modelo_id')
      ->join('modelos_procesos','modelos_procesos.id','=','modelos_procesos_relacionados.modelos_proceso_id')
      ->select('modelos.nombre AS nombre_modelo','modelos_procesos.nombre AS nombre_tipo_proceso','modelos.id')
      ->orderBy('modelos.created_at','desc')->get();

    foreach($modelos->all() as $dato) {
      $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
    }

    return View::make('modelo.index', array("datos" => $modelos));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function vercodigos()
  {
    if(Auth::user()){
      $modelos  = ModeloCodigo::orderBy('descripcion')->get();

      return View::make('modelo.vercodigos', array("datos" => $modelos));
    }
    else{
      return Redirect::route('index')
            ->withErrors(array('error' => 'Debe loguearse para poder usar la aplicación.'));
    }
  }

  public function buscarcodigos() 
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
      return Redirect::route('modelos.vercodigos');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('modelos.resultadoscodigos', $datos);
  }  

  public function resultadoscodigos($datos) 
  {
    $datos_array = explode('&', $datos);
    
    foreach($datos_array as $valor) {
      $subarray = explode('=', $valor);

      if($subarray[0] === 'created_at_desde'){
        $param[$subarray[0]] = $this->convertir_fecha_us($subarray[1]);
      }
      else if($subarray[0] === 'created_at_hasta'){
        $param[$subarray[0]] = $this->convertir_fecha_us($subarray[1]);
      }
      else {
        $param[$subarray[0]] = $subarray[1];
      }
    }

    $modelos  = ModeloCodigo::BuscarFiltros($param)->orderBy('descripcion')->get();

    return View::make('modelo.vercodigos', array("datos" => $modelos));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function crear()
  {

    if(Input::get()) {
      $inputs = $this->getInputs(Input::all());
      if($this->validateForms($inputs, true) === true) {

        $modelo = new Modelo($inputs);

        if($modelo->save()){
          $tipo_proceso = Input::get("tipo_proceso");
          $tipo_proceso = ModeloTipoProceso::where('nombre','=',$tipo_proceso)->first();
          
          $relacion = new ModeloTipoProcesoRelacionado;

          $relacion->modelos_proceso_id = $tipo_proceso->id;
          $relacion->modelo_id = $modelo->id;

          if($relacion->save()){
            return Redirect::to('modelos/index')
              ->with(array('mensaje' => 'El Modelo ha sido creado correctamente.'));
          }
        }
      }
      else {
        return Redirect::route('modelos.crear')
          ->withErrors($this->validateForms($inputs,true))->withInput();
      }
    }
    else{
      return View::make("modelo.crear");
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function modificar($id) {
    $datos = array('' => 'Seleccione...');

    if(Input::get()) {
      $relacion = ModeloTipoProcesoRelacionado::find($id);

      if($relacion) {
        $inputs = $this->getInputs(Input::all());

        if($this->validateForms($inputs, false) === true) {
          $modelo_id = Input::get("modelo_id");          
          $modelo = Modelo::find($modelo_id);
          $modelo->nombre = Input::get("nombre");
          $modelo->texto  = Input::get("texto");

          if($modelo->save()){
            $nombre_tipo_proceso = Input::get("tipo_proceso");
            $tipo_proceso = ModeloTipoProceso::where('nombre',$nombre_tipo_proceso)->first();

            $relacion->modelo_id          = Input::get("modelo_id");
            $relacion->modelos_proceso_id = $tipo_proceso->id;

            if($relacion->save()){
              return Redirect::to('modelos/index')->with(array('mensaje' => 'El Modelo se ha actualizado correctamente.'));
            }
          }
        }
        else {
          return Redirect::route('modelos.modificar', array('modelo_id' => $id))
            ->withErrors($this->validateForms($inputs))->withInput();
        }
      }
      else {
          return Redirect::to('modelos/index')->with(array('mensaje' => 'El Modelo no existe.'));          
      }
    }
    else {
      $modelo  = Modelo::join('modelos_procesos_relacionados','modelos.id','=','modelos_procesos_relacionados.modelo_id')
        ->join('modelos_procesos','modelos_procesos.id','=','modelos_procesos_relacionados.modelos_proceso_id')
        ->select('modelos.nombre AS nombre_modelo','modelos.texto AS texto',
            'modelos_procesos.nombre AS nombre_tipo_proceso','modelos.id AS modelo_id', 
            'modelos_procesos_relacionados.id AS modelos_procesos_relacionado_id')
        ->where('modelos.id',$id)->first();

      return View::make("modelo.modificar", array('modelo' => $modelo));  
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function eliminar($id)
  {
    $modelo = Modelo::find($id);

    if($modelo){

      $relacion = ModeloTipoProcesoRelacionado::where('modelo_id',$id);
      $relacion->delete();

      $modelo->delete();
      return Redirect::to('modelos/index')->with(array('mensaje' => 'El Modelo ha sido eliminado correctamente.'));
    }
    else{
      return Redirect::route('modelos.index')
        ->with(array('mensaje' => "El Modelo con id $id que intentas eliminar no existe."));
    }
  }
  
  private function validateForms($inputs = array(), $is_insert = true){

    if($is_insert) {
      $rules = array(
        'nombre'        => 'required',
        'tipo_proceso'  => 'required',
        'texto'         => 'required'
      );
    }
    else {

      /* Hacer verificación de Email y DNI contra el resto de clientes... */

      $rules = array(
        'nombre'        => 'required',
        'tipo_proceso'  => 'required',
        'texto'         => 'required'
      );
    }

    $messages = array(
      'required'  => 'El campo :attribute es obligatorio.',
      'min'       => 'El campo :attribute no puede tener menos de :min carácteres.',
      'max'       => 'El campo :attribute no puede tener más de :min carácteres.'
    );


    $validation = Validator::make($inputs, $rules, $messages);

    if($validation->fails()){

      return $validation;
    }
    else{
      return true;
    }
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
}
