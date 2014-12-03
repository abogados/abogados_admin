<?php
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
 
class BackupsController extends BaseController { 

   /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::user()){
      $backups  = Backup::orderBy('created_at','desc')->get();

      foreach($backups->all() as $dato) {
        $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
      }

      return View::make('backup.index', array("datos" => $backups));
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
      return Redirect::route('backups.index');
    }

    $datos = substr($datos, 0, -1);

    return Redirect::route('backups.resultados', $datos);
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

    $modelos  = Backup::BuscarFiltros($param)
      ->orderBy('created_at','desc')->paginate(10);

    foreach($modelos->all() as $dato) {
      $dato->creado_at = $this->convertir_fecha_es($dato->created_at);
    }

    return View::make('backup.index', array("datos" => $modelos));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
    public function crear_dbase() {

      $database = Config::get('database.connections.mysql.database');

      return View::make("backup.crear_dbase", array("nombre_dbase" => $database));
    }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
    public function crear_dbase_linux() {

        if(Input::get()) {
            $inputs = $this->getInputs(Input::all());
            if($this->validateForms($inputs, true) === true) {
                $nombre_archivo = Input::get("nombre");

                $host = Config::get('database.connections.mysql.host');
                $database = Config::get('database.connections.mysql.database');
                $username = Config::get('database.connections.mysql.username');
                $password = Config::get('database.connections.mysql.password');
                $backupPath = app_path() . "/storage/backup/";
                $backupFileName = $nombre_archivo . "-" . date("Y-m-d-H-i-s") . '.sql';
                $backupFullZipName = $nombre_archivo . "-" . date("Y-m-d-H-i-s") . '.zip';

                $path = "/usr/bin/mysqldump";
                $command = $path . " --user=" . $username . " --password='" . $password . "' " . $database . " > " . $backupPath . $backupFileName;
                system($command, $retval);

                if($retval === 0){

                  $command = "zip app/storage/backup/".$backupFullZipName . " app/storage/backup/".$backupFileName;
                  system($command, $retvalZip);

                  if($retvalZip === 0){

                    $command = "rm app/storage/backup/".$backupFileName;
                    system($command, $retvalZip);

                    $backup = new Backup($inputs);

                    $backup->nombre = $backupFullZipName;
                    $backup->tipo   = 'Database';

                    if($backup->save()){
                      return Redirect::to('backups/index')
                        ->with(array('mensaje' => 'El Backup de la Base de Datos ha sido creada correctamente.'));
                    }
                    else{
                      return Redirect::route('backups.crear_dbase')
                        ->withErrors(array('error' => 'Ocurrió un error al intentar grabar el registro del Backup de la Base de Datos.'))->withInput();
                    }
                  }
                  else{
                    return Redirect::route('backups.crear_dbase')
                      ->withErrors(array('error' => 'Ocurrió un error al intentar Comprimir del Backup de la Base de Datos.'))->withInput();
                  }
                }
                else{
                  return Redirect::route('backups.crear_dbase')
                    ->withErrors(array('error' => 'Ocurrió un error al intentar generar el Backup de la Base de Datos.'))->withInput();
                }
            }
            else {
                return Redirect::route('backups.crear_dbase')
                  ->withErrors($this->validateForms($inputs,true))->withInput();
              }
        }
        else{
            $database = Config::get('database.connections.mysql.database');

            return View::make("backup.crear_dbase", array("nombre_dbase" => $database));
        }
    }

    /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
    public function crear_dbase_windows() {

        if(Input::get()) {
            $inputs = $this->getInputs(Input::all());
            if($this->validateForms($inputs, true) === true) {
                $nombre_archivo = Input::get("nombre");

                $host = Config::get('database.connections.mysql.host');
                $database = Config::get('database.connections.mysql.database');
                $username = Config::get('database.connections.mysql.username');
                $password = Config::get('database.connections.mysql.password');
                $backupPath = app_path() . "\storage\backup\\";
                $backupFileName = $nombre_archivo . "-" . date("Y-m-d-H-i-s") . '.sql';
                $backupFullZipName = $nombre_archivo . "-" . date("Y-m-d-H-i-s") . '.zip';

                $path = "C:\\xampp\mysql\bin\mysqldump";
                $command = $path . " -u" . $username . " -p" . $password . " --databases " . $database . " --result-file=" . $backupPath . $backupFileName;
                system($command, $retval);
                
                if($retval === 0){

                  $zip = new ZipArchive();

                  if($zip->open($backupPath . $backupFullZipName, ZIPARCHIVE::CREATE) === true) {
                    $zip->addFile($backupPath . $backupFileName);
                    $zip->close();

                    $command = "del " . $backupPath . $backupFileName;
                    system($command, $retvalZip);

                    $backup = new Backup($inputs);

                    $backup->nombre = $backupFullZipName;
                    $backup->tipo   = 'Database';

                    if($backup->save()){
                      return Redirect::to('backups/index')
                        ->with(array('mensaje' => 'El Backup de la Base de Datos ha sido creada correctamente.'));
                    }
                    else{
                      return Redirect::route('backups.crear_dbase')
                        ->withErrors(array('error' => 'Ocurrió un error al intentar grabar el registro del Backup de la Base de Datos.'))->withInput();
                    }
                  }
                  else{
                    return Redirect::route('backups.crear_dbase')
                      ->withErrors(array('error' => 'Ocurrió un error al intentar Comprimir del Backup de la Base de Datos.'))->withInput();
                  }
                }
                else{
                  return Redirect::route('backups.crear_dbase')
                    ->withErrors(array('error' => 'Ocurrió un error al intentar generar el Backup de la Base de Datos.'))->withInput();
                }
            }
            else {
                return Redirect::route('backups.crear_dbase')
                  ->withErrors($this->validateForms($inputs,true))->withInput();
              }
        }
        else{
            $database = Config::get('database.connections.mysql.database');

            return View::make("backup.crear_dbase", array("nombre_dbase" => $database));
        }
    }

    private function validateForms($inputs = array(), $is_insert = true){

    if($is_insert) {
      $rules = array(
        'nombre'        => 'required|unique:backups'
      );
    }
    else {

      /* Hacer verificación de Email y DNI contra el resto de clientes... */

      $rules = array(
        'nombre'        => 'required',
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

  public function getDownloadFile($zip_file){
    $ZipFilePath = app_path() . "\storage\backup\\";
    $file= $ZipFilePath . $zip_file;

    $headers = array(
          'Content-Type: octet-stream',
          'Content-disposition: attachment; filename=test.zip'
        );
    return Response::download($file, $zip_file, $headers);
  }
}