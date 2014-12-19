<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AgendaAlarma extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'agenda:alarma';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Busca y envía por mail Recodatorios de las Agendas de los Empleados.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$fecha_actual = date('Y-m-d');
      	$hora_actual  = date('H:i');
      	$fecha = new DateTime($fecha_actual." ".$hora_actual);
      	$fecha->add(new DateInterval('PT0H1M')); //P(obligatorio) T(time) 0H(0 horas) 10M(30 minutos)
      	$fecha_nueva = $fecha->format('Y-m-d');
      	$hora_nueva  = $fecha->format('H:i');

      	$agendas = Agenda::wherebetween('fecha_alarma', array($fecha_actual, $fecha_nueva))
        	->wherebetween('hora_alarma',array($hora_actual, $hora_nueva))->get();
        
        if($agendas->count() > 0) {
        	print "Se encontraron ".$agendas->count()." Eventos disponibles entre ".$fecha_actual." ".$hora_actual." y ".$fecha_nueva." ".$hora_nueva;

        	foreach($agendas as $dato){
        		$user = '';
	       		$user = Usuario::where('id',$dato->usuario_id)->first();

	       		Mail::send('emails.alarma.agenda_recordatorio', array('dato' => $dato, 'nombre' => $user->nombre), function($message) use ($user){
					$message->to($user->email, $user->nombre)->subject('Recordatorio de su Agenda.');
					});

	       		print "\nMail enviado al Usuario '".$user->user."' a su Correo: ".$user->email;
	        }
		}
		else{
			print "No se encontraron Eventos disponibles entre ".$fecha_actual." ".$hora_actual." y ".$fecha_nueva." ".$hora_nueva;
		}
	}
}
