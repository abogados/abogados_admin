<?php

class RemindersController extends Controller {

	/**
	 * Muestra form recuperar contraseña
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('password.remind');
	}

	/**
	 * Realiza el envío de una nueva contraseña (form olvidé mi contraseña)
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		$validator = Validator::make(Input::all(),
			array(
				'email' => 'required|email'
				));

		if($validator->fails()){
			return Redirect::route('password.remind')
				->withErrors($validator)
				->withInput();
		}
		else{
			$user = Usuario::where('email','=',Input::get('email'));

			if($user->count()){
				$user = $user->first();

				$codigo 	= str_random(60);
				$password = str_random(10);

				$user->codigo 			= $codigo;
				$user->password_temp 	= Hash::make($password);

				if($user->save()){
					Mail::send('emails.auth.forgot', array('link' => URL::route('password.recover', $codigo), 'username' => $user->nombre, 'password' => $password), function($message) use ($user){
						$message->to($user->email, $user->nombre)->subject('Tu nueva contraseña.');
					});

					return Redirect::route('index')
						->withErrors(array('error' => 'El nuevo Password fue enviado por email.'));
				}
			}
			else {
				return Redirect::route('password.remind')
					->withErrors(array('error' => 'No se pudo enviar el nuevo Password. El E-mail ingresado no existe en la base de datos.'));				
			}
		}

		return Redirect::route('password.remind')
			->withErrors(array('error' => 'No se pudo enviar el nuevo Password.'));
	}

	/**
	 * Reestablece la constraseña del usuario con una nueva contraseña temporal (form olvidé mi contraeseña)
	 *
	 * @return Response
	 */
	public function getRecover($codigo)
	{
		$user = Usuario::where('codigo','=',$codigo)
			->where('password_temp','!=','');

		if($user->count()){
			$user = $user->first();

			$user->password 		= $user->password_temp;
			$user->password_temp	= '';
			$user->codigo			= '';

			if($user->save()){

				return Redirect::route('index')
					->withErrors(array('message' => 'Su contraseña ha sido modificada y puede ingresar con su nueva contraseña.'));
			}

			return Redirect::route('index')
				->with(array('message' => 'No se pudo recuperar su contraseña.'));
		}		
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	/*public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);
	}*/

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	/*public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::to('index');
		}
	}*/

	/**
	 * form Cambiar mi contraseña de un usuario logueado
	 *
	 * @return Response
	 */
	public function getChangePassword()
	{
		return View::make('password.password');
	}

	/**
	 * genera el cambio de contraseña de un usuario logueado
	 *
	 * @return Response
	 */
	public function postChangePassword()
	{

		$validator = Validator::make(Input::all(),
				array(
					'old_password' 		=> 'required',
					'password' 				=> 'required|min:6',
					'password_repeat' => 'required|same:password'
					)
			);

		if($validator->fails()){
			return Redirect::route('password-change-password')
			->withErrors($validator);
		}
		else{

			if(Input::get('old_password') != Input::get('password')) {
				
				$user = Usuario::find(Auth::user()->id);

				$old_password 		= Input::get('old_password');
				$password 				= Input::get('password');
				$password_repeat 	= Input::get('password_repeat');

				if(Hash::check($old_password, $user->getAuthPassword())) {
					$user->password = Hash::make($password);

					if($user->save()){
						return Redirect::route('dashboard')
							->withErrors(array('error' => 'Su contraseña ha sido modificada.'));
					}
					else{
						return Redirect::route('password-change-password')
							->withErrors(array('error' => 'Su contraseña anterior es incorrecta.'));					
					}
				}
			}
			else{
				return Redirect::route('password-change-password')
					->withErrors(array('error' => 'Su contraseña no pudo ser modificada. No puede volver a ingresar la misma contraseña.'));
			}
		}

		return Redirect::route('password-change-password')
			->withErrors(array('error' => 'Su contraseña no pudo ser modificada. Reingrese los datos.'));
	}
}
