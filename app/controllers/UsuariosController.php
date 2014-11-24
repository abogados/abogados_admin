<?php

class UsuariosController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){
      $usuarios = Usuario::where('parentesco','=','Titular')->orderBy('created_at','desc')->get();

      foreach($usuarios->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }
      
      return View::make('usuario.index', array("datos" => $usuarios));
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
      return Redirect::route('usuarios.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('usuarios.resultados', $datos);
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

    $usuarios  = Usuario::BuscarFiltros($param)
      ->orderBy('created_at','desc')->paginate(10);

    foreach($usuarios->all() as $dato) {
      $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
    }

    return View::make('usuario.index', array("datos" => $usuarios));
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
      if($this->validateForms($inputs,true) === true) {
        $usuario = new Usuario($inputs);

        if($usuario->save()){
          return Redirect::to('usuarios/index')->with(array('mensaje' => 'El Empleado ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::to('usuarios/crear')->withErrors($this->validateForms($inputs, true))->withInput();
      }
    }
    else{
      return View::make("usuario.crear");
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
    $usuario = Usuario::find($id);
   
    if(Input::get()) {
      if($usuario) {
        $inputs = $this->getInputs(Input::all());

        if($this->validateForms($inputs,false) === true) {
         
          $usuario->nombre      = Input::get("nombre");
          $usuario->apellido    = Input::get("apellido");
          $usuario->dni         = Input::get("dni");
          $usuario->domicilio   = Input::get("domicilio");
          $usuario->email       = Input::get("email");
          $usuario->perfil      = Input::get("perfil");
          $usuario->user        = Input::get("user");
          $usuario->password    = Input::get("password");
          $usuario->estado      = Input::get("estado");
          $usuario->parentesco  = Input::get("parentesco");

          if($usuario->save()){
            return Redirect::to('usuarios/index')->with(array('mensaje' => 'El Empleado se ha actualizado correctamente.'));
          }
        }
        else {
          return Redirect::to("usuarios/modificar/$id")->withErrors($this->validateForms($inputs, false))->withInput();
        }
      }
      else {
          return Redirect::to('usuarios/index')->with(array('mensaje' => 'El Empleado no existe.'));          
      }
    }
    else {
      return View::make("usuario.modificar", array("usuario" => $usuario));  
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function modificar_gf($id) {
    $usuario = Usuario::find($id);

    if(Input::get()) {
      if($usuario) {
        //traigo el grupo familiar completo existente para eliminarlo e insertarlos de nuevo
        $usuario_gf = Usuario::where('titular_id','=',$id)  ->where('id','!=',$id);

        if($usuario_gf->count() > 0) {
          $usuario_gf->delete();
        }

        $inputs = $this->getInputs_gf(Input::all());

        foreach($inputs as $arrays) {
          foreach($arrays as $datos) {

            if($this->validateForms_gf($datos) === true) {

              $usuario = new Usuario($inputs);

              foreach($datos as $indice => $valor) {
                $usuario->$indice = $valor;         
              }

              $usuario->titular_id  = $id;
              $usuario->estado      = 'Activo';

              if(!$usuario->save()){
                return Redirect::to("usuarios/modificar_gf/$id")->withErrors(array('mensaje' => 'Ocurrió un error al intentar modificar el Grupo Familiar del Empleado.'));
              }

            }
            else {
              return Redirect::to("usuarios/modificar_gf/$id")->withErrors($this->validateForms_gf($inputs))->withInput();
            }
          }

          $usuario_titular = Usuario::find($id);
          $usuario_titular->titular_id = $id;

          if(!$usuario_titular->save()) {
            return Redirect::to("usuarios/modificar_gf/$id")->withErrors(array('mensaje' => 'Ocurrió un error al intentar actualizar el Titular del Grupo Familiar.'));
          }
        }

        return Redirect::to('usuarios/index')->with(array('mensaje' => 'El Grupo Familiar del Empleado se ha actualizado correctamente.'));
      }
      else {
          return Redirect::to('usuarios/index')->with(array('mensaje' => 'El Empleado no existe.'));          
      }
    }
    else {
      return View::make("usuario.modificar_gf", array("usuario" => $usuario));  
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
    $usuario = Usuario::find($id);

    if($usuario){
      $usuario->delete();
      return Redirect::to('usuarios/index')->with(array('mensaje' => 'El Usuario ha sido eliminado correctamente.'));
    }else{
      return Redirect::to('usuarios/index')->with(array('mensaje' => "El Usuario con id $id que intentas eliminar no existe."));
    }
  }
  
  private function validateForms($inputs = array(), $is_insert = true){
    
    if($is_insert){
      $rules = array(
        'nombre'      => 'required|min:2|max:100',
        'apellido'    => 'required|min:2|max:100',
        'email'       => 'required|min:2|max:100|unique:usuarios|email',
        'dni'         => 'required|min:8|max:8|unique:usuarios',
        'perfil'      => 'required',
        'user'        => 'required|min:2|max:100|unique:usuarios',
        'estado'      => 'required',
        'parentesco'  => 'required'
      );
    }
    else{

      /* Hacer verificación de Email, DNI y User contra el resto de usuarios... */

      $rules = array(
        'nombre'      => 'required|min:2|max:100',
        'apellido'    => 'required|min:2|max:100',
        'email'       => 'required|min:2|max:100',
        'dni'         => 'required|min:8|max:8',
        'perfil'      => 'required',
        'user'        => 'required|min:2|max:100',
        'estado'      => 'required',
        'parentesco'  => 'required'
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

  private function validateForms_gf($inputs = array()){

    $rules = array(
      'nombre'      => 'required|min:2|max:100',
      'apellido'    => 'required|min:2|max:100',
      'dni'         => 'required|min:8|max:8',
      'parentesco'  => 'required'
    ); 
        
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

  //método privado para obtener los inputs del formulario
  private function getInputs_gf($inputs = array()){
    foreach($inputs as $key => $val){
        if($key != '_token'){
          $inputs2[$key] = $val;
        }
    }

    return $inputs2;
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

  public function solapas()
  {
    return View::make('usuario.solapas');
  }

  public function solapas_mod($id)
  {
    $usuario = Usuario::find($id);


    // $usuario_gf = Usuario::where('titular_id','=',$id)
    //   ->where('id','!=',$id)
    //   ->select('nombre', 'apellido','dni','parentesco')
    //   ->get();
      
    // print "<pre>";
    // print_r($usuario_gf->all());
    // print "</pre>";

    // $queries = DB::getQueryLog();
    // $last_query = end($queries);
    // print "<pre>";
    // print_r($last_query);
    // print "</pre>";
    // exit;
    
    // $i = 0;
    // foreach($usuario_gf->all() as $dato) {
    //   $gf[$i]['nombre'] = $dato->nombre;
    //   $gf[$i]['apellido'] = $dato->apellido;
    //   $gf[$i]['dni'] = $dato->dni;
    //   $gf[$i]['parentesco'] = $dato->parentesco;
    //   $i++;
    // }
    
    // print "<pre>";
    // print $gf[0]['nombre'];
    // print "</pre>";
    // exit;

    return View::make('usuario.solapas_mod', array('usuario' => $usuario));
  }

  public function getItemType($tipo_solapa)
  {
    $id = Input::get("usuario_id");

    if($id != '') { 
      $usuario = Usuario::find($id);

      if ($tipo_solapa === 'titular') {      
        return View::make("usuario.modificar", array("usuario" => $usuario));
      } 

      return View::make("usuario.modificar_gf", array("usuario" => $usuario));
    }
    else {
      return View::make("usuario.crear");
    }
  }

}