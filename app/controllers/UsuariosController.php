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
      $usuarios = Usuario::where('parentesco','=','Titular')
        ->orderBy('apellido','desc','nombre','desc')->get();

      foreach($usuarios->all() as $dato) {
        $dato->total_grupo_familiar = Usuario::where('titular_id', '=', $dato->id)->where('parentesco','!=','Titular')
        ->count();

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
      ->where('parentesco','=','Titular')
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

        if(trim(Input::get("password")) === trim(Input::get("password_repeat"))) {
          $usuario = new Usuario($inputs);

          $usuario->password          = Hash::make(Input::get("password"));
          $usuario->fecha_nacimiento  = $this->convertir_fecha_us($usuario->fecha_nacimiento);
          $usuario->fecha_ingreso     = $this->convertir_fecha_us($usuario->fecha_ingreso);

          if($usuario->save()){
            return Redirect::to('usuarios/index')->withErrors(array('mensaje' => 'El Empleado ha sido creado correctamente.'));
          }
        }
        else{
          return Redirect::to('usuarios/solapas')->withErrors(array('error' => 'Contraseña y Repetir Contraseña deben coincidir. Ingrese correctamente por favor.'))->withInput();
        }
      }
      else {
        return Redirect::to('usuarios/solapas')->withErrors($this->validateForms($inputs, true))->withInput();
      }
    }
    else{
      return View::make("usuario.solapas");
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
         
          $usuario->apellido          = Input::get("apellido");
          $usuario->nombre            = Input::get("nombre");
          $usuario->parentesco        = Input::get("parentesco");
          $usuario->dni               = Input::get("dni");
          $usuario->estado_civil      = Input::get("estado_civil");
          $usuario->sexo              = Input::get("sexo");
          $usuario->domicilio         = Input::get("domicilio");
          $usuario->localidad         = Input::get("localidad");
          $usuario->telefono          = Input::get("telefono");
          $usuario->celular           = Input::get("celular");
          $usuario->fecha_nacimiento  = $this->convertir_fecha_us(Input::get("fecha_nacimiento"));
          $usuario->profesion         = Input::get("profesion");
          $usuario->email             = Input::get("email");

          $usuario->fecha_ingreso     = $this->convertir_fecha_us(Input::get("fecha_ingreso"));
          $usuario->legajo            = Input::get("legajo");
          $usuario->perfil            = Input::get("perfil");
          $usuario->user              = Input::get("user");
          if(Input::get("password") != '') {
            $usuario->password          = Hash::make(Input::get("password"));
          }
          $usuario->estado            = Input::get("estado");
          
          if($usuario->save()){
            return Redirect::to('usuarios/index')->withErrors(array('mensaje' => 'El Empleado se ha actualizado correctamente.'));
          }
        }
        else {
          return Redirect::to("usuarios/solapas_mod/$id")->withErrors($this->validateForms($inputs, false))->withInput();
        }
      }
      else {
          return Redirect::to('usuarios/index')->withErrors(array('mensaje' => 'El Empleado no existe.'));          
      }
    }
    else {
      return View::make("usuario.modificar", array('usuario' => $usuario));
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
        /*$usuario_gf = Usuario::where('titular_id','=',$id)  ->where('id','!=',$id);

        if($usuario_gf->count() > 0) {
          $usuario_gf->delete();
        }*/

        $inputs = $this->getInputs_gf(Input::all());

        foreach($inputs as $arrays) {
          foreach($arrays as $datos) {

            if($datos['nombre'] != "" && $datos['apellido'] != "" && $datos['parentesco'] != "" && $datos['dni'] != "") {

              if($this->validateForms_gf($datos) === true) {

                $usuario = new Usuario($inputs);
              
                foreach($datos as $indice => $valor) {
                  if($indice == 'fecha_nacimiento') {
                    $usuario->$indice  = $this->convertir_fecha_us($valor);
                  }
                  else{
                    $usuario->$indice = $valor;
                  }
                }

                $usuario->titular_id  = $id;
                $usuario->estado      = 'Activo';

                if(!$usuario->save()){
                  return Redirect::to("usuarios/solapas_mod/$id")->withErrors(array('mensaje' => 'Ocurrió un error al intentar modificar el Grupo Familiar del Empleado.'));
                }
              }
              else {
                return Redirect::to("usuarios/solapas_mod/$id")->withErrors($this->validateForms_gf($inputs))->withInput();
              }
            }
          }

          $usuario_titular = Usuario::find($id);
          $usuario_titular->titular_id = $id;

          if(!$usuario_titular->save()) {
            return Redirect::to("usuarios/solapas_mod/$id")->withErrors(array('mensaje' => 'Ocurrió un error al intentar actualizar el Titular del Grupo Familiar.'));
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
      return Redirect::to('usuarios/index')->with(array('mensaje' => 'El Empleado ha sido eliminado correctamente.'));
    }
    else{
      return Redirect::to('usuarios/index')->with(array('mensaje' => "El Empleado con id $id que intentas eliminar no existe."));
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function eliminar_gf($gf_id, $id)
  {
    $usuario_gf = Usuario::find($gf_id);

    if($usuario_gf){
      $usuario_gf->delete();
      return Redirect::to('usuarios/solapas_mod/'.$id);
    }
    else{
      return Redirect::to('usuarios/solapas_mod/'.$id)->with(array('mensaje' => "El Miembre del Grupo Familiar con id $gf_id que intentas eliminar no existe."));
    }
  }
  
  private function validateForms($inputs = array(), $is_insert = true){
    
    if($is_insert){
      $rules = array(
        'nombre'            => 'required|min:2|max:100',
        'apellido'          => 'required|min:2|max:100',
        'email'             => 'min:2|max:100|unique:usuarios|email',
        'dni'               => 'required|min:8|max:8|unique:usuarios',
        'perfil'            => 'required',
        'user'              => 'required|min:2|max:100|unique:usuarios',
        'estado'            => 'required',
        'parentesco'        => 'required',
        'legajo'            => 'required'
      );
    }
    else{

      /* Hacer verificación de Email, DNI y User contra el resto de usuarios... */

      $rules = array(
        'nombre'            => 'required|min:2|max:100',
        'apellido'          => 'required|min:2|max:100',
        'email'             => 'min:2|max:100',
        'dni'               => 'required|min:8|max:8',
        'perfil'            => 'required',
        'user'              => 'required|min:2|max:100',
        'estado'            => 'required',
        'parentesco'        => 'required',
        'legajo'            => 'required'
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
      'nombre'            => 'required|min:2|max:100',
      'apellido'          => 'required|min:2|max:100',
      'dni'               => 'required|min:8|max:8',
      'parentesco'        => 'required',
      'fecha_nacimiento'  => 'required'
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
      else {
        $hora = '';
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

    return View::make('usuario.solapas_mod', array('usuario' => $usuario));
  }

  public function getItemType($tipo_solapa)
  {
    $id = Input::get("usuario_id");

    if($id != '') { 
      $usuario = Usuario::find($id);

      if ($tipo_solapa === 'titular') {
        $usuarios_gf = Usuario::where('titular_id','=', $usuario->id)
          ->where('parentesco','!=','Titular')
          ->orderBy('apellido','desc', 'nombre','desc')->get();

        foreach($usuarios_gf as $dato) {
          if($dato->fecha_nacimiento != '') {
            $dato->fecha_nacimiento = $this->convertir_fecha_es($dato->fecha_nacimiento);
          }
        }

        return View::make("usuario.modificar", array('usuario' => $usuario, 'grupo_familiar' => $usuarios_gf));
      } 

      return View::make("usuario.modificar_gf", array('usuario' => $usuario));
    }
    else {
      return View::make("usuario.crear");
    }
  }

}
