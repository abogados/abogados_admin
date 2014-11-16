<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Usuario extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usuarios';
	protected $fillable = array('nombre','apellido','user','password','dni','domicilio','perfil'
		,'email','estado','fecha_nacimiento','titular_id','parentesco');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static function scopeBuscarFiltros($query, $datos, $operador = 'LIKE')
    {

    	foreach($datos as $campo => $valor){

	    	if (!empty($valor)) {
	    		if($campo === 'created_at_desde'){
					$query->where(str_replace('_desde', '', $campo), '>=', $valor.' 00:00:00');
	    		}
	    		elseif($campo === 'created_at_hasta'){
					$query->where(str_replace('_hasta', '', $campo), '<=', $valor.' 23:59:59');
	    		}
	    		elseif($campo === 'apenom'){
					$query->where('nombre', $operador, '%'.$valor.'%');
					$query->orWhere('apellido', $operador, '%'.$valor.'%');
	    		}
	    		elseif($campo === 'dni'){
					$query->where($campo, '=', $valor);
	    		}
	    		else{
					$query->where($campo, $operador, '%'.$valor.'%');
				}
	    	}
	    	else {
				$query->where($campo, $operador, '%');
	    	}
	    }
	    
	    return $query;
    }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
}
