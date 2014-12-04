<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Pago extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pagos';
	protected $fillable = array('tipo_pago','tipo_operacion','monto','estado','expediente_id');

	public function scopeBuscarFiltros($query, $datos, $operador = 'LIKE')
    {

    	foreach($datos as $campo => $valor){

    		$campo = str_replace('__', '.', $campo);

	    	if (!empty($valor)) {
	    		if($campo === 'created_at_desde'){
					$query->where(str_replace('_desde', '', $campo), '>=', $valor);
	    		}
	    		elseif($campo === 'created_at_hasta'){
					$query->where(str_replace('_hasta', '', $campo), '<=', $valor);
	    		}
	    		elseif(substr($campo, -6) === 'estado'){
					$query->where($campo, '=', $valor);
	    		}
	    		if($campo === 'monto_desde'){
					$query->where(str_replace('_desde', '', $campo), '>=', $valor);
	    		}
	    		elseif($campo === 'monto_hasta'){
					$query->where(str_replace('_hasta', '', $campo), '<=', $valor);
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
