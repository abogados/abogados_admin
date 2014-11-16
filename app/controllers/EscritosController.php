<?php

class EscritosController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){
      $escritos  = Escrito::join('expedientes', 'escritos.expediente_id', '=', 'expedientes.id')
        ->select('escritos.*','expedientes.numero', 'expedientes.tipo_proceso')
        ->orderBy('escritos.created_at','desc')->get();

      foreach($escritos->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }

      return View::make('escrito.index', array("datos" => $escritos));
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

    $datos = array('' => 'Seleccione...');
    $expedientes  = Expediente::where('estado','!=','Finalizado')->orderBy('numero')->get();

    foreach($expedientes->all() as $dato) {
      $datos[$dato->id] = $dato->numero;
    }

    if(Input::get()) {

      $inputs['titulo'] = Input::get("titulo");
      $inputs['expediente_id'] = Input::get("expediente_id");
      $inputs['descripcion'] = Input::get("descripcion");
      $inputs['estado'] = Input::get("estado");
      $inputs['cuerpo'] = Input::get("cuerpo");

      if($this->validateForms($inputs, true) === true) {

        $escrito = new Escrito($inputs);

        if($escrito->save()){
          return Redirect::to('escritos/index')
            ->with(array('mensaje' => 'El Escrito ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::route('escritos.crear')
          ->withErrors($this->validateForms($inputs,true))->withInput();
      }
    }
    else{
      return View::make("escrito.crear", array("expedientes" => $datos));
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
    $expedientes  = Expediente::where('estado','!=','Finalizado')->orderBy('numero')->get();

    foreach($expedientes->all() as $dato) {
      $datos[$dato->id] = $dato->numero;
    }
    
    if(Input::get()) {
      if($escrito) {
        $inputs = $this->getInputs(Input::all());

        if($this->validateForms($inputs, false) === true) {

          $escrito->titulo        = Input::get("titulo");
          $escrito->expediente_id = Input::get("expediente_id");
          $escrito->descripcion   = Input::get("descripcion");
          $escrito->estado        = Input::get("estado");
          $escrito->cuerpo        = Input::get("cuerpo");

          if($escrito->save()){
            return Redirect::to('escritos/index')->with(array('mensaje' => 'El Escrito se ha actualizado correctamente.'));
          }
        }
        else {
          return Redirect::route('escritos.modificar', array('escrito_id' => $id))
            ->withErrors($this->validateForms($inputs))->withInput();
        }
      }
      else {
          return Redirect::to('escritos/index')->with(array('mensaje' => 'El Escrito no existe.'));          
      }
    }
    else {
      return View::make("escrito.modificar", array('escrito' => $escrito, 'expedientes' => $datos));  
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
      return Redirect::to('escritos/index')->with(array('mensaje' => 'El Escrito ha sido eliminado correctamente.'));
    }
    else{
      return Redirect::route('escritos.index')
        ->with(array('mensaje' => "El Escrito con id $id que intentas eliminar no existe."));
    }
  }
  
  private function validateForms($inputs = array(), $is_insert = true){

    if($is_insert) {
      $rules = array(
        'expediente_id' => 'required',
        'titulo'        => 'required|unique:escritos',
        'descripcion'   => 'required',
        'estado'        => 'required',
        'cuerpo'        => 'required'
      );
    }
    else {

      /* Hacer verificación de Email y DNI contra el resto de clientes... */

      $rules = array(
        'expediente_id' => 'required',
        'titulo'        => 'required',
        'descripcion'   => 'required',
        'estado'        => 'required',
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
}
