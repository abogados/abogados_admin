<?php
class AuthController extends BaseController {
 
    /**
     * Attempt user login
     */
    public function doLogin()
    {
        // Obtenemos el email, borramos los espacios
        // y convertimos todo a minúscula
        $user = mb_strtolower(trim(Input::get('user')));
        // Obtenemos la contraseña enviada
        $password = Input::get('password');
 
        // Realizamos la autenticación
        if (Auth::attempt(['user' => $user, 'password' => $password])){
            // Aquí también pueden devolver una llamada a otro controlador o
            // devolver una vista

            // $queries = DB::getQueryLog();
            // $last_query = end($queries);
            // print "<pre>";
            // print_r($last_query);
            // print "</pre>";
            // exit;

            if($this->control_usuario_activo($user)){
                return Redirect::route('dashboard');
            }
            else{
                return Redirect::route('index')
                    ->withErrors(array('mensaje' => 'El Usuario está deshabilitado. No puede ingresar al sistema.'));
            }
        }
 
        return Redirect::route('index')
            ->withErrors(array('mensaje' => 'Datos incorrectos, vuelve a intentarlo.'));
    }
 
    public function doLogout()
    {
        //Desconctamos al usuario
        Auth::logout();
 
        //Redireccionamos al inicio de la app con un mensaje
        return Redirect::route('index')
            ->withErrors(array('error' => 'Gracias por usar nuestro Sistema!.'));
    }

    public function control_usuario_activo($usuario)
    {
        $usuario = Usuario::where('user',$usuario);

        if($usuario->first()->estado != 'Activo'){
            Auth::logout();

            return 0;
        }

        return 1;
    }
}
