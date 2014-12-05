<?php

class EscritosController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index($expediente_id = NULL)
  {
    if(Auth::user()){

      if($expediente_id > 0) {
        Session::put('expediente_id', $expediente_id);

        $escritos  = Escrito::join('expedientes', 'escritos.expediente_id', '=', 'expedientes.id')
          ->where('escritos.expediente_id',$expediente_id)
          ->select('escritos.*','expedientes.caratula', 'expedientes.tipo_proceso')
          ->orderBy('escritos.created_at','desc')->get();
      }
      else{
        if(Session::has('expediente_id')) {
          Session::forget('expediente_id');
        }

        $escritos  = Escrito::join('expedientes', 'escritos.expediente_id', '=', 'expedientes.id')
          ->select('escritos.*','expedientes.numero', 'expedientes.tipo_proceso')
          ->orderBy('escritos.created_at','desc')->get();
      }

      foreach($escritos->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }

      if(Session::has('expediente_id')) {
        $expediente  = Expediente::where('id',Session::get('expediente_id'))->first();
      }
      else {
        $expediente  = array();
      }

      return View::make('escrito.index', array("datos" => $escritos, "exped_id" => Session::get('expediente_id'), 'expediente_datos' => $expediente));
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
      return Redirect::route('escritos.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('escritos.resultados', $datos);
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

    $escritos  = Escrito::join('expedientes', 'escritos.expediente_id', '=', 'expedientes.id')
        ->select('escritos.*','expedientes.numero', 'expedientes.tipo_proceso')
        ->BuscarFiltros($param)
        ->orderBy('created_at','desc')->paginate(10);

    foreach($escritos->all() as $dato) {
      $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
    }

    return View::make('escrito.index', array("datos" => $escritos));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function crear()
  {
    if(Input::get()) {

      $inputs['titulo'] = Input::get("titulo");
      $inputs['expediente_id'] = Input::get("expediente_id");
      $inputs['cuerpo'] = Input::get("cuerpo");

      if($this->validateForms($inputs, true) === true) {

        $escrito = new Escrito($inputs);

        if($escrito->save()){
          return Redirect::to('escritos/index/'.Session::get('expediente_id'))
            ->with(array('mensaje' => 'El Escrito ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::route('escritos.crear')
          ->withErrors($this->validateForms($inputs,true))->withInput();
      }
    }
    else{
      $datos = array('' => 'Seleccione...');
      $expedientes  = Expediente::orderBy('numero')->get();

      foreach($expedientes->all() as $dato) {
        $datos[$dato->id] = $dato->numero;
      }

      if(Session::has('expediente_id')) {
        $expediente  = Expediente::where('id',Session::get('expediente_id'))->first();
      }
      else {
        $expediente  = array();
      }

      return View::make("escrito.crear", array("expedientes" => $datos, "expediente_datos" => $expediente, "exped_id" => Session::get('expediente_id')));
    }
  }

/**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function crear_desde_modelo()
  {
    if(Input::get()) {

      $inputs['titulo'] = Input::get("titulo");
      $inputs['expediente_id'] = Input::get("expediente_id");
      $inputs['cuerpo'] = Input::get("cuerpo");

      if($this->validateForms($inputs, true) === true) {

        $escrito = new Escrito($inputs);

        if($escrito->save()){
          return Redirect::to('escritos/index/'.Session::get('expediente_id'))
            ->with(array('mensaje' => 'El Escrito ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::route('escritos.crear_desde_modelo')
          ->withErrors($this->validateForms($inputs,true))->withInput();
      }
    }
    else{
      $datos = array('' => 'Seleccione...');
      $expedientes  = Expediente::orderBy('numero')->get();

      foreach($expedientes->all() as $dato) {
        $datos[$dato->id] = $dato->numero;
      }

      if(Session::has('expediente_id')) {
        $expediente  = Expediente::where('id',Session::get('expediente_id'))->first();
      }
      else {
        $expediente  = array();
      }

      return View::make("escrito.crear_desde_modelo", array("expedientes" => $datos, "expediente_datos" => $expediente, "exped_id" => Session::get('expediente_id')));
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
    
    $escrito = Escrito::find($id);
    
    if(Input::get()) {
      if($escrito) {
        $inputs = $this->getInputs(Input::all());

        if($this->validateForms($inputs, false) === true) {

          $escrito->titulo        = Input::get("titulo");
          $escrito->expediente_id = Input::get("expediente_id");
          $escrito->cuerpo        = Input::get("cuerpo");

          if($escrito->save()){
            return Redirect::to('escritos/index/'.Session::get('expediente_id'))
              ->withErrors(array('mensaje' => 'El Escrito se ha actualizado correctamente.'));
          }
        }
        else {
          return Redirect::route('escritos.modificar', array('escrito_id' => $id))
            ->withErrors($this->validateForms($inputs))->withInput();
        }
      }
      else {
          return Redirect::to('escritos/index/'.Session::get('expediente_id'))
            ->withErrors(array('mensaje' => 'El Escrito no existe.'));
      }
    }
    else {

      $expedientes  = Expediente::orderBy('numero')->get();
      foreach($expedientes->all() as $dato) {
        $datos[$dato->id] = $dato->numero;
      }


      if(Session::has('expediente_id')) {
        $expediente  = Expediente::where('id',Session::get('expediente_id'))->first();
      }
      else {
        $expediente  = array();
      }

      return View::make("escrito.modificar", array('escrito' => $escrito, 'expedientes' => $datos, "expediente_datos" => $expediente, "exped_id" => Session::get('expediente_id')));
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
    $escrito = Escrito::find($id);

    if($escrito){
      $escrito->delete();
      return Redirect::to('escritos/index')->withErrors(array('mensaje' => 'El Escrito ha sido eliminado correctamente.'));
    }
    else{
      return Redirect::to('escritos/index/'.Session::get('expediente_id'))
        ->withErrors(array('mensaje' => "El Escrito con id $id que intentas eliminar no existe."));
    }
  }
  
  private function validateForms($inputs = array(), $is_insert = true){

    if($is_insert) {
      $rules = array(
        'expediente_id' => 'required',
        'titulo'        => 'required',
        'cuerpo'        => 'required'
      );
    }
    else {

      /* Hacer verificación de Email y DNI contra el resto de clientes... */

      $rules = array(
        'expediente_id' => 'required',
        'titulo'        => 'required',
        'cuerpo'        => 'required'
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

  public function buscar_modelos_listado(){
    $tipo_proceso = Input::get('tipo_proceso');

    $modelos  = Modelo::where('tipo_proceso',$tipo_proceso)->orderBy('nombre')->get();

    $salida = "<label for='modelo_id' class='col-sm-2 col-sm-2-10 control_form_label'>Modelo</label>";
    $salida .= "<div class='col-sm-10 col-sm-10-30'>";
    $salida .= "<select class='form-control' id='modelo_id' name='modelo_id' onchange='modelo_id_onchange(this.value)'>";
    $salida .= "<option value='' selected='selected'>Seleccione...</option>";
    
    foreach($modelos as $dato) {
      $salida .= "<option value='".$dato->id."'>".$dato->nombre."</option>";
    }

    $salida .= "</select>";
    $salida .= "</div>";

    return Response::json($salida);
  }

  public function buscar_modelo_codigos(){

    $modelo_id    = Input::get('modelo_id');

    $modelo  = Modelo::where('id',$modelo_id)->first();
    $codigos  = ModeloCodigoRelacionado::where('nombre_modelo',$modelo->nombre)->get();

    $salida = "<div class='form-group'>";
    foreach($codigos as $dato) {
        $salida .= "<label for='".$dato->codigo."' class='col-sm-2 col-sm-2-50 control_form_label_left'>".$dato->descripcion."</label>";
        $salida .= "<div class='col-sm-10 col-sm-10-80'>";
        $salida .= "<input class='form-control' name='".$dato->codigo."' type='text' id='".$dato->codigo."'>";
        $salida .= "</div>";
    }
    $salida .= "</div>";

    return Response::json($salida);
  }
}
