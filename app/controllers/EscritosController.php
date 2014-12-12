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

      $inputs['expediente_id'] = Input::get("expediente_id");
      $inputs['cuerpo'] = Input::get("cuerpo");
      $modelo_id = Input::get("modelo_id");

      $modelo  = Modelo::where('id',$modelo_id)->first();
      $inputs['titulo'] = $modelo->nombre;

      if($this->validateForms($inputs, true) === true) {

        $escrito = new Escrito($inputs);

        $escrito->titulo    = $modelo->nombre;
        $escrito->modelo_id = $modelo_id;

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

        $expediente_tipo_proceso = ModeloTipoProceso::where('nombre',$expediente->tipo_proceso)->first();
      }
      else {
        $expediente  = array();
        $expediente_tipo_proceso = array();
      }

      return View::make("escrito.crear_desde_modelo", array("expedientes" => $datos, "expediente_datos" => $expediente, "exped_id" => Session::get('expediente_id'), 'expediente_tipo_proceso' => $expediente_tipo_proceso));
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
  
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function imprimir($id = NULL)
  {
    if(Auth::user()){
      $escrito = Escrito::find($id);
      $expediente = Expediente::find($escrito->expediente_id);
      $cliente = Cliente::find($expediente->cliente_id);

      return View::make('escrito.imprimir', array("datos" => $escrito, "expediente" => $expediente));
    }
    else{
      return Redirect::route('index')
            ->withErrors(array('error' => 'Debe loguearse para poder usar la aplicación.'));
    }
  }

  public function buscar_tipos_procesos(){
    $tipo_proceso_id = Input::get('tipo_proceso_id');

    $modelos  = ModeloTipoProceso::where('id', $tipo_proceso_id)->orderBy('nombre')->get();

    $salida = "<label for='tipo_proceso_id' class='col-sm-2 col-sm-2-10 control_form_label'>Tipo de Proceso</label>";
    $salida .= "<div class='col-sm-10 col-sm-10-30'>";
    $salida .= "<select class='form-control' id='tipo_proceso_id' name='tipo_proceso_id' onchange='tipo_proceso_onchange(this.value)'>";
    //$salida .= "<option value='' selected='selected'>Seleccione...</option>";
    
    foreach($modelos as $dato) {
      $salida .= "<option value='".$dato->id."'>".$dato->nombre."</option>";
    }

    $salida .= "</select>";
    $salida .= "</div>";

    return Response::json($salida);
  }

  public function buscar_modelos_listado(){
    $tipo_proceso_id = Input::get('tipo_proceso_id');

    $modelos = ModeloTipoProcesoRelacionado::join('modelos_procesos', 'modelos_procesos.id', '=', 'modelos_procesos_relacionados.modelos_proceso_id')
      ->join('modelos', 'modelos_procesos_relacionados.modelo_id', '=', 'modelos.id')
      ->select('modelos.id','modelos.nombre')
      ->where('modelos_procesos_relacionados.modelos_proceso_id',$tipo_proceso_id)->orderBy('nombre')->get();

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

    $codigos  = ModeloCodigoRelacionado::join('modelos', 'modelos_codigos_relacionados.modelo_id', '=', 'modelos.id')
      ->join('modelos_codigos', 'modelos_codigos_relacionados.modelos_codigo_id', '=', 'modelos_codigos.id')
      ->select('modelos_codigos.codigo','modelos_codigos.descripcion')
      ->where('modelos_codigos_relacionados.modelo_id',$modelo_id)->get();

    if($codigos->count() > 0){
      $salida = "<div class='form-group'>";
      foreach($codigos as $dato) {
          $salida .= "<label for='".$dato->codigo."' class='col-sm-2 col-sm-2-50 control_form_label_no_left'>".$dato->descripcion."</label>";
          $salida .= "<div class='col-sm-10 col-sm-10-80'>";
          $salida .= "<input class='form-control' name='".$dato->codigo."' type='text' id='".$dato->codigo."' />";
          $salida .= "</div>";
      }
      $salida .= "</div>";

      $salida .= "<div class='form-group'>
              <div class='col-sm-offset-2 col-sm-offset-2-1'>
                <input type='button' id='btnGenerar' name='btnGenerar' value='Generar Escrito' class='btn btn-default' onClick='generar_escrito_onclick()' />
              </div>
          </div>";
    }
    else{
      $salida = "<div class='form-group'>No se encontraron atributos relacionados para cargar.</div>";
    }

    return Response::json($salida);
  }

  public function generar_escrito_reemplazo_codigos(){

    $modelo_id    = Input::get('modelo_id');
    $codigos_modelo = Input::get('codigos_modelo');

    $codigos_modelo = substr($codigos_modelo, 0, -2);

    $modelo  = Modelo::where('id',$modelo_id)->first();
    $escrito = $modelo->texto;

    $codigos_modelo_array = explode("||", $codigos_modelo);
    
    $escrito_generado = $escrito;
    $cod = "";
    foreach($codigos_modelo_array as $dato) {
      $codigo = "";
      $codigo = explode("=", $dato);

      if($codigo[1] != '' && $codigo[0] != 'btnGenerar') {
        if($codigo[1] == '-') {
          $escrito_generado = str_replace(trim($codigo[0]), ' ', $escrito_generado);
        }
        else{
          $texto = $this->reemplazar_caracteres_especiales($codigo[1]);
          $escrito_generado = str_replace(trim($codigo[0]), trim($texto), $escrito_generado);
        }
      }
    }

    $salida = "<div class='form-group'>
        <div class='col-sm-10 col-sm-10-85'>
          <textarea name='cuerpo' id='cuerpo' 'class'='form-control texto_largo' 'cols'='300' 'rows'='8'>".$escrito_generado."</textarea>
          <script type='text/javascript'>
              CKEDITOR.replace( 'cuerpo' );
          </script>
        </div>
    </div>";

    return Response::json($salida);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function importar()
  {
    $expediente_id = Input::get('expediente_id');

    $salida = "<form class='form-horizontal' role='form' enctype='multipart/form-data' id='formulario_importacion'>";
    $salida .= "<input type='hidden' id='exped_id' name='exped_id' value='".$expediente_id."' />";
    $salida .= "<div class='form-group' style='margin-top:20px;'>
        <div class='col-sm-10 col-sm-10-30' style='margin-left:80px;'>
            <input type='file' name='archivo' id='archivo' class='btn btn-default' accept='.doc,.rtf,.jpg,.png,.docx'>
        </div>
    </div>";
    $salida .= "<br /><br />
      <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-offset-2-40'>
              <input class='btn btn-default' type='button' value='Confirmar' onClick='importacion_subir_archivo()'>
          </div>
      </div>";
    $salida .= "</form>";

    return Response::json($salida);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function importar_subir_archivo_windows()
  {
    
    //comprobamos que sea una petición ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
    {
   
      //obtenemos el archivo a subir
      $file = utf8_decode($_FILES['archivo']['name']);
      $file_db = $_FILES['archivo']['name'];
      
      $control_extension = substr($file, -4);

      if(strtolower($control_extension) == ".rtf" || strtolower($control_extension) == ".doc" 
        || strtolower($control_extension) == "docx") {

        $backupPath = app_path() . "\storage\backup\\";
        $escritosPath = $backupPath."escritos\\";

        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos
        if(!is_dir($escritosPath)) 
            mkdir($escritosPath, 0777);
         
        //comprobamos si el archivo ha subido
        if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],$escritosPath.$file))
        {
           sleep(3);//retrasamos la petición 3 segundos

            //Hacer el insert en la base de datos.
            $expediente_id = $_POST['exped_id'];

            $importacion = new EscritoImportacion;

            $importacion->expediente_id = $expediente_id;
            $importacion->nombre_archivo = $file_db;

            if($importacion->save()){
              $mensaje = "El archivo ".$file_db." fue subido en forma correcta.";
            }
            else{
              $mensaje = "Ocurrió un error al intentar subir el archivo ".$file_db.".<br />
                      Intente nuevamente. Si el error persiste comuníquese con el Administrador.";
            }
        }
      }
      else{
        $mensaje = "Ocurrió un error al intentar subir el archivo ".$file_db.".<br />
                    El tipo de archivo que está intentando subir no es de extensión válida.";
      }
    }
    else{
      $mensaje = "Ocurrió un error al intentar subir el archivo ".$file_db.".<br />
                Intente nuevamente. Si el error persiste comuníquese con el Administrador.";
    }

    $salida = "<div class='form-group' style='margin-top:20px;'>
        <label class='col-sm-2 col-sm-2-99 control_form_label_text_center'>".$mensaje."</label>
      </div>";
    $salida .= "<br /><br /><br />
      <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-offset-2-40'>
              <input class='btn btn-default' type='button' value='Cerrar' onClick='importacion_cerrar_popup()'>
          </div>
      </div>";


    return Response::json($salida);
  }

  public function importar_escritos_listado() {
    $salida .= "<div>HOLAAAAA</div>";

    return Response::json($salida);
  }

  public function reemplazar_caracteres_especiales($texto) {

    $salida = str_replace('%E1','á',$texto);
    $salida = str_replace('%E9','é',$salida);
    $salida = str_replace('%ED','í',$salida);
    $salida = str_replace('%F3','ó',$salida);
    $salida = str_replace('%FA','ú',$salida);
    $salida = str_replace('%F1','ñ',$salida);
    $salida = str_replace('%D1','Ñ',$salida);

    $salida = str_replace('%20',' ',$salida);
    $salida = str_replace('%21','!',$salida);
    $salida = str_replace('%22','"',$salida);
    $salida = str_replace('%23','#',$salida);
    $salida = str_replace('%2F','/',$salida);
    $salida = str_replace('%25','%',$salida);
    $salida = str_replace('%24','$',$salida);
    $salida = str_replace('%26','&',$salida);
    $salida = str_replace('%27','\'',$salida);
    $salida = str_replace('%28','(',$salida);
    $salida = str_replace('%29',')',$salida);
    $salida = str_replace('%2A','*',$salida);
    $salida = str_replace('%2B','+',$salida);
    $salida = str_replace('%2C',',',$salida);
    $salida = str_replace('%3A',':',$salida);
    $salida = str_replace('%3B',';',$salida);
    $salida = str_replace('%3C','<',$salida);
    $salida = str_replace('%3D','=',$salida);
    $salida = str_replace('%3E','>',$salida);
    $salida = str_replace('%3F','?',$salida);
    $salida = str_replace('%BF','¿',$salida);
    $salida = str_replace('%5F','_',$salida);
    $salida = str_replace('%7B','{',$salida);
    $salida = str_replace('%7C','|',$salida);
    $salida = str_replace('%7D','}',$salida);
    $salida = str_replace('%7E','~',$salida);

    return $salida;
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
}
