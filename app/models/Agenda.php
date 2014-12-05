<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Agenda extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'agendas';
	protected $fillable = array('descripcion','tipo_evento','fecha',
      'hora_inicio','hora_fin','fecha_alarma',
      'hora_alarma','observaciones');

	public static function scopeBuscarFiltros($query, $datos, $operador = 'LIKE')
    {

    	foreach($datos as $campo => $valor){

    		$campo = str_replace('__', '.', $campo);

	    	if (!empty($valor)) {
	    		if($campo === 'fecha_desde'){
					$query->where(str_replace('_desde', '', $campo), '>=', $valor);
	    		}
	    		elseif($campo === 'fecha_hasta'){
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
