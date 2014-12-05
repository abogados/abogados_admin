<?php

class ClientesController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){
      $clientes = Cliente::orderBy('created_at','desc')->get();

      foreach($clientes->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }
    
      return View::make('cliente.index', array("datos" => $clientes));
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
      return Redirect::route('clientes.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('clientes.resultados', $datos);
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

    $clientes  = Cliente::BuscarFiltros($param)
      ->orderBy('created_at','desc')->paginate(10);

    foreach($clientes->all() as $dato) {
      $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
    }

    return View::make('cliente.index', array("datos" => $clientes));
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
        
        $cliente = new Cliente($inputs);

        if($cliente->save()){
          return Redirect::to('clientes/index')->with(array('mensaje' => 'El Cliente ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::to('clientes/crear')->withErrors($this->validateForms($inputs))->withInput();
      }
    }
    else{
      return View::make("cliente.crear");
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function mostrar($id)
  {
    $usuario = Usuario::find($id);

    #return 'Nombre y apellido: '.$usuario->nombre.' '.$usuario->apellido;
    return View::make('usuario.mostrar',array('datos' => $usuario));
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function modificar($id) {
    $cliente = Cliente::find($id);
    
    if(Input::get()) {
      if($cliente) {
        $inputs = $this->getInputs(Input::all());

        if($this->validateForms($inputs, false) === true) {
         
           $cliente->nombre     = Input::get("nombre");
           $cliente->apellido   = Input::get("apellido");
           $cliente->dni        = Input::get("dni");
           $cliente->email      = Input::get("email");
           $cliente->domicilio  = Input::get("domicilio");
           $cliente->localidad  = Input::get("localidad");
           $cliente->telefono   = Input::get("telefono");
           $cliente->celular    = Input::get("celular");

          if($cliente->save()){
            return Redirect::to('clientes/index')->with(array('mensaje' => 'El usuario se ha actualizado correctamente.'));
          }
        }
        else {
          return Redirect::route('clientes.modificar', array('cliente_id' => $id))
            ->withErrors($this->validateForms($inputs, false))->withInput();
        }
      }
      else {
          return Redirect::to('clientes/index')->with(array('mensaje' => 'El usuario no existe.'));          
      }
    }
    else {
      return View::make("cliente.modificar", array("cliente" => $cliente));  
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
    $cliente = Cliente::find($id);

    if($cliente){
      $cliente->delete();
      return Redirect::to('clientes/index')->with(array('mensaje' => 'El Cliente ha sido eliminado correctamente.'));
    }else{
      return Redirect::to('clientes/index')->with(array('mensaje' => "El Cliente con id $id que intentas eliminar no existe."));
    }
  }
  
  private function validateForms($inputs = array(), $is_insert = true){

    if($is_insert) {
      $rules = array(
        'nombre'    => 'required|min:2|max:100',
        'apellido'  => 'required|min:2|max:100',
        'email'     => 'required|min:2|max:100|unique:clientes|email',
        'dni'       => 'required|min:8|max:8|unique:clientes'
      );
    }
    else {

      /* Hacer verificación de Email y DNI contra el resto de clientes... */

      $rules = array(
        'nombre'    => 'required|min:2|max:100',
        'apellido'  => 'required|min:2|max:100',
        'email'     => 'required|min:2|max:100|email',
        'dni'       => 'required|min:8|max:8'
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

      $fecha_es = $dia . "-" . $mes . "-" .$ano . " " . $hora; 

      return  $fecha_es;
    }
    else {
      return $fecha_en;
    }
  }
}
