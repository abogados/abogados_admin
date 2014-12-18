@extends('layout.base_index')
 
@section('titulo')
    <div class='titulo_home_remind_password'>
        <div class='logo'><img src="/images/logo.png" height="55" /></div>
        <h4>LawSie</h4>
        <h4>Olvid&eacute; mi contrase&ntilde;a</h4>
    </div>
@stop

@section('contenido')

  <div class="contenedor_inicio_sesion">
    
    @section('mensajes_error')
       @if(isset($errors))
        @foreach ($errors->all() as $error)
            <div class="show_error">{{ $error }}</div>
        @endforeach
      @endif
    @stop

    <h4><b>Ingrese su e-mail y presione Enviar para recibir su Usuario<br /> y una nueva Contraseña en su casilla de correo:</b></h4>

    {{ Form::open(array('route' => 'password.remind.post', 'class' => 'form-horizontal', 'role' => 'form')) }}

      <div class="form-group">
          {{ Form::label('email', 'E-mail', array('class' => 'col-sm-2  control-label')) }}
          <div class="col-sm-10 col-sm-10-30">
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

  </div>

@stop
