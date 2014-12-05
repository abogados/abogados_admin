<?php
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LegajosController extends BaseController { 

   public function index(){
      return View::make('legajo.index');
   } 

   public function buscar(){
      $empleados = array(
         array(
            'legajo' => '123',
            'nombre' => 'Cornelio',
            'apellido' => 'Del Rancho',
            'area' => 'Programación'
         ),
         array(
            'legajo' => '456',
            'nombre' => 'Modesto',
            'apellido' => 'Rosado',
            'area' => 'Recursos humanos'
         ),
         array(
            'legajo' => '789',
            'nombre' => 'Humberto',
            'apellido' => 'Vélez',
            'area' => 'Seguridad'
         )
       );
       $legajo = Input::get('legajo');
       foreach($empleados as $item){
          if($item['legajo'] == $legajo){
             return Response::json($item);
          }
       }
       return 0;
    }
}
