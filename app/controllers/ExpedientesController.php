<?php

class ExpedientesController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){
      $expedientes  = Expediente::join('clientes', 'expedientes.cliente_id', '=', 'clientes.id')
        ->where('clientes.estado', 'Activo')
        ->orderBy('expedientes.created_at','desc')->get();

      // foreach($expedientes->all() as $dato) {
      //   $dato->fecha_inicio       = $this->convertir_fecha_es($dato->fecha_inicio);
      //   $dato->fecha_presentacion = $this->convertir_fecha_es($dato->fecha_presentacion);
      //   $dato->fecha_finalizacion = $this->convertir_fecha_es($dato->fecha_finalizacion);
      // }

      return View::make('expediente.index', array("datos" => $expedientes));
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
      return Redirect::route('expedientes.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('expedientes.resultados', $datos);
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

    $expedientes  = Expediente::BuscarFiltros($param)
      ->orderBy('created_at','desc')->paginate(10);

    return View::make('expediente.index', array("datos" => $expedientes));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function crear()
  {

    $datos = array('' => 'Seleccione...');
    $clientes  = Cliente::where('estado','Activo')->orderBy('apellido')->orderBy('nombre')->get();

    foreach($clientes->all() as $dato) {
      $datos[$dato->id] = $dato->apellido." ".$dato->nombre;
    }

    if(Input::get()) {
      $inputs = $this->getInputs(Input::all());

      if($this->validateForms($inputs, true) === true) {
        
        $expediente = new Expediente($inputs);

        $expediente->fecha_inicio       = $this->convertir_fecha_us($expediente->fecha_inicio);
        $expediente->fecha_presentacion = $this->convertir_fecha_us($expediente->fecha_presentacion);
        $expediente->fecha_finalizacion = $this->convertir_fecha_us($expediente->fecha_finalizacion);

        if($expediente->save()){
          return Redirect::to('expedientes/index')->with(array('mensaje' => 'El Expediente ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::route('expedientes.crear')
          ->withErrors($this->validateForms($inputs,true))->withInput();
      }
    }
    else{
      return View::make("expediente.crear", array("clientes" => $datos));
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
    
    $expediente = Expediente::find($id);
    $clientes   = Cliente::where('estado','Activo')->orderBy('apellido')->orderBy('nombre')->get();

    foreach($clientes->all() as $dato) {
      $datos[$dato->id] = $dato->apellido." ".$dato->nombre;
    }
    
    if(Input::get()) {
      if($expediente) {
        $inputs = $this->getInputs(Input::all());

        if($this->validateForms($inputs, false) === true) {
         
          $expediente->cliente_id           = Input::get("cliente_id");
          $expediente->numero               = Input::get("numero");
          $expediente->caratula             = Input::get("caratula");
          $expediente->juzgado              = Input::get("juzgado");
          $expediente->estado               = Input::get("estado");
          $expediente->fecha_inicio         = $this->convertir_fecha_us(Input::get("fecha_inicio"));
          $expediente->fecha_presentacion   = $this->convertir_fecha_us(Input::get("fecha_presentacion"));
          $expediente->fecha_finalizacion   = $this->convertir_fecha_us(Input::get("fecha_finalizacion"));
          $expediente->tipo_proceso         = Input::get("tipo_proceso");
          $expediente->pagos                = Input::get("pagos");

          if($expediente->save()){
            return Redirect::to('expedientes/index')->with(array('mensaje' => 'El usuario se ha actualizado correctamente.'));
          }
        }
        else {
          return Redirect::route('expedientes.modificar', array('expediente_id' => $id))
            ->withErrors($this->validateForms($inputs))->withInput();
        }
      }
      else {
          return Redirect::to('expedientes/index')->with(array('mensaje' => 'El usuario no existe.'));          
      }
    }
    else {
      return View::make("expediente.modificar", array('expediente' => $expediente, 'clientes' => $datos));  
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
    $expediente = Expediente::find($id);

    if($expediente){
      $expediente->delete();
      return Redirect::to('expedientes/index')->with(array('mensaje' => 'El Expediente ha sido eliminado correctamente.'));
    }
    else{
      return Redirect::to('expedientes/index')->with(array('mensaje' => "El Expediente con id $id que intentas eliminar no existe."));
    }
  }
  
  private function validateForms($inputs = array(), $is_insert = true){

    if($is_insert) {
      $rules = array(
        'cliente_id'  => 'required',
        'numero'      => 'required|unique:expedientes',
        'caratula'    => 'required|unique:expedientes',
        'juzgado'     => 'required',
        'estado'      => 'required',
        'fecha_inicio'        => 'required',
        'fecha_presentacion'  => 'required',
        'fecha_finalizacion'  => 'required',
        'tipo_proceso'        => 'required'
      );
    }
    else {

      /* Hacer verificación de Email y DNI contra el resto de clientes... */

      $rules = array(
        'cliente_id'  => 'required',
        'numero'      => 'required',
        'caratula'    => 'required',
        'juzgado'     => 'required',
        'estado'      => 'required',
        'fecha_inicio'        => 'required',
        'fecha_presentacion'  => 'required',
        'fecha_finalizacion'  => 'required',
        'tipo_proceso'        => 'required'
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

      $fecha_es = $dia . "-" . $mes . "-" .$ano; 

      return  $fecha_es;
    }
    else {
      return $fecha_en;
    }
  }
}
