<?php

class AgendasController extends BaseController {

  public function conectar(){
    setlocale(LC_NUMERIC,"es_ES");
    $host_name = "localhost"; 
    $host_port = 3306;
    $username = "root";
    $password = "1234";

    $mysqli = mysqli_init();
    if (!$mysqli) {
        die('Falló mysqli_init');
    }

    $link = $mysqli->real_connect($host_name , $username, $password, "abogados");

    if (!$link) {
        die('Error de conexión (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }


    /*$link = mysqli::real_connect($host_name , $username, $password, "abogados", MYSQL_CLIENT_COMPRESS);
    if(!$link){
        die("No pudo conectarse. ".mysql_error());
    }*/

    //$mysqli->close();

    return $mysqli; 
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){
      $agendas = Agenda::where('usuario_id',Auth::user()->id)->orderBy('created_at','desc')->get();

      foreach($agendas->all() as $dato) {
        $dato->fecha = $this->convertir_fecha_es($dato->fecha);
      }
    
      return View::make('agenda.index', array("datos" => $agendas));
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
      return Redirect::route('agendas.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('agendas.resultados', $datos);
  }  

  public function resultados($datos) 
  {
    $datos_array = explode('&', $datos);

    foreach($datos_array as $valor) {
      $subarray = explode('=', $valor);

      if($subarray[0] === 'fecha_desde'){
        $param[$subarray[0]] = $this->convertir_fecha_us($subarray[1]);
      }
      else if($subarray[0] === 'fecha_hasta'){
        $param[$subarray[0]] = $this->convertir_fecha_us($subarray[1]);
      }
      else {
        $param[$subarray[0]] = $subarray[1];
      }
    }

    $agendas  = Agenda::BuscarFiltros($param)
        ->where('usuario_id',Auth::user()->id)
        ->orderBy('created_at','desc')->paginate(10);

    foreach($agendas->all() as $dato) {
      $dato->fecha = $this->convertir_fecha_es($dato->fecha);
    }
  
    return View::make('agenda.index', array("datos" => $agendas));
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
      if($this->validateForms($inputs) === true) {
        
        $agenda = new Agenda($inputs);

        $agenda->fecha        = $this->convertir_fecha_us($agenda->fecha);
        $agenda->fecha_alarma = $this->convertir_fecha_us($agenda->fecha_alarma);
        $agenda->usuario_id   = Auth::user()->id;

        if($agenda->save()){
          return Redirect::route('agendas.index')
            ->withErrors(array('mensaje' => 'La Tarea/Recordatorio ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::route('agendas.crear')
            ->withErrors($this->validateForms($inputs))->withInput();
      }
    }
    else{
      return View::make("agenda.crear");
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function modificar($id) {
    $agenda = Agenda::find($id);
    
    if(Input::get()) {
      if($agenda) {
        $inputs = $this->getInputs(Input::all());

        if($this->validateForms($inputs) === true) {
         
           $agenda->descripcion   = Input::get("descripcion");
           $agenda->tipo_evento   = Input::get("tipo_evento");
           $agenda->fecha         = $this->convertir_fecha_us(Input::get("fecha"));
           $agenda->fecha_alarma  = $this->convertir_fecha_us(Input::get("fecha_alarma"));
           $agenda->hora_alarma   = Input::get("hora_alarma");
           $agenda->observaciones = Input::get("observaciones");
           $agenda->usuario_id    = Auth::user()->id;

          if($agenda->save()){
            return Redirect::route('agendas.index')
              ->withErrors(array('mensaje' => 'La Tarea/Recordatorio se ha actualizado correctamente.'));
          }
        }
        else {
          return Redirect::route('agendas.modificar', array('agenda_id' => $id))
            ->withErrors($this->validateForms($inputs))->withInput();
        }
      }
      else {
          return Redirect::route('agendas.index')
            ->withErrors(array('mensaje' => 'La Tarea/Recordatorio no existe.'));          
      }
    }
    else {
      $agenda->fecha = $this->convertir_fecha_es($agenda->fecha);
      $agenda->fecha_alarma = $this->convertir_fecha_es($agenda->fecha_alarma);

      return View::make("agenda.modificar", array("agenda" => $agenda));  
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
    $agenda = Agenda::find($id);

    if($agenda){
      $agenda->delete();

      return Redirect::route('agendas.index')
              ->withErrors(array('mensaje' => 'El Recordatorio/Tarea ha sido eliminado correctamente.'));
    }else{
      return Redirect::route('agendas.index')
              ->withErrors(array('mensaje' => 'El Recordatorio/Tarea con id $id que intentas eliminar no existe.'));
    }
  }
  
  private function validateForms($inputs = array()){
    $rules = array(
      'descripcion' => 'required|min:2|max:100',
      'tipo_evento' => 'required',
      'fecha'       => 'required|min:10|max:10'
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
