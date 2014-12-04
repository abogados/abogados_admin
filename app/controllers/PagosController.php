<?php

class PagosController extends BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $datos = array('' => 'Todos');

    if(Auth::user()){
      $pagos  = Pago::leftjoin('expedientes', 'pagos.expediente_id', '=', 'expedientes.id')
      ->select('pagos.*', 'expedientes.caratula')
        ->orderBy('created_at','desc')->get();

      foreach($pagos->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }

      $expedientes  = Expediente::where('estado','!=','Finalizado')->orderBy('numero')->get();

      foreach($expedientes->all() as $dato) {
        $datos[$dato->id] = $dato->caratula;
      }

      return View::make('pago.index', array("datos" => $pagos, "expedientes" => $datos));
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
      return Redirect::route('pagos.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('pagos.resultados', $datos);
  }  

  public function resultados($datos) 
  {
    $datos_exp = array('' => 'Todos');
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

    $pagos  = Pago::leftjoin('expedientes', 'pagos.expediente_id', '=', 'expedientes.id')
      ->select('pagos.*', 'expedientes.numero')
      ->BuscarFiltros($param)
      ->orderBy('created_at','desc')->get();

/*    $queries = DB::getQueryLog();
    $last_query = end($queries);
    print "<pre>";
    print_r($last_query);
    print "</pre>";
    exit;*/

    /*print "<pre>";
    print_r($pagos);
    print "</pre>";*/

    foreach($pagos as $dato) {
      $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
    }

    $expedientes  = Expediente::where('estado','!=','Finalizado')->orderBy('numero')->get();

    foreach($expedientes as $dato) {
      $datos_exp[$dato->id] = $dato->caratula;
    }

    return View::make('pago.index', array("datos" => $pagos, "expedientes" => $datos_exp));
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

        if($inputs["tipo_operacion_egr"] && isset($inputs['expediente_id'])) {
          unset($inputs['expediente_id']);
        }

        $pago = new Pago($inputs);

        if(Input::get("tipo_operacion_ing"))  $pago->tipo_operacion   = Input::get("tipo_operacion_ing");
        if(Input::get("tipo_operacion_egr"))  $pago->tipo_operacion   = Input::get("tipo_operacion_egr");
        
        if($pago->save()){
          return Redirect::to('pagos/index')
            ->with(array('mensaje' => 'El pago ha sido creado correctamente.'));
        }
      }
      else {
        return Redirect::route('pagos.crear')
          ->withErrors($this->validateForms($inputs,true))->withInput();
      }
    }
    else{
      $datos = array('' => 'Seleccione...');
      $expedientes  = Expediente::where('estado','!=','Finalizado')
                        ->orderBy('numero')->get();

      foreach($expedientes->all() as $dato) {
        //$datos[$dato->id] = $dato->numero;
        $datos[$dato->id] = $dato->caratula;
      }

      return View::make("pago.crear", array("expedientes" => $datos));
    }
  }

  private function validateForms($inputs = array(), $is_insert = true){

    if($is_insert) {
      $rules = array(
        'tipo_pago'       => 'required',
        'monto'           => 'required'
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
