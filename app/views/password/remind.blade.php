@extends('layout.base_index')
 
@section('titulo')
    <div class='titulo_home_index'>
        <h5>:: Estudio Abogados ::</h5>
        <h4>Olvid&eacute; mi contrase&ntilde;a</h4>
    </div>
@stop

@section('contenido')
    
    @section('mensajes_error')
       @if(isset($errors))
        @foreach ($errors->all() as $error)
            <div class="show_error">{{ $error }}</div>
        @endforeach
      @endif
    @stop

    <h5><b>Ingrese su e-mail y presione Enviar para recibir una nueva contraseña en su casilla de correo:</b></h5>

    {{ Form::open(array('route' => 'password.remind.post', 'class' => 'form-horizontal', 'role' => 'form')) }}

      <div class="form-group">
          {{ Form::label('email', 'E-mail', array('class' => 'col-sm-2  control-label')) }}
          <div class="col-sm-10">
              {{ Form::text('email', null, array('class' => 'form-control')) }}
          </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Enviar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Volver al Home', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/'")) }}
        </div>
      </div>
     
    {{ Form::close() }}

@stop
