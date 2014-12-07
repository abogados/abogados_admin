<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class ModeloCodigo extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'modelos_codigos';

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
}
