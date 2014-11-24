@extends('layout.base_index')
 
@section('titulo')
    <div class='titulo_home_index'>
        <h1>:: Estudio Abogados ::</h1>
        <p>Sistema de Gesti&oacute;n de Expedientes para Estudios Jur&iacute;dicos.</p>
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

        <div class="titulo_login_index">
            <p>Inicio de Sesi&oacute;n</p>
        </div>
     
        {{ Form::open(array('url' => '/login', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form')) }}

            <div class="form-group">
                {{ Form::label('user', 'Usuario', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
                <div class="col-sm-10 col-sm-10-30">
                    {{ Form::text('user',null, array('class' => 'form-control')) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('password', 'Contrase&ntilde;a', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
                <div class="col-sm-10 col-sm-10-30">
                    {{ Form::password('password', array('class' => 'form-control')) }}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-offset-2-10 col-sm-10">
                    {{ Form::submit('Ingresar', array('class' => 'btn btn-default btn-default-ancho')) }}
                </div>
            </div>

            <div class="contenedor_blanco_chico">
                <a href="{{ URL::route('password.remind') }}" style="text-decoration:none;">Olvid&eacute; mi Contrase&ntilde;a</a>
            </div>

        {{ Form::close() }}

    </div>

@stop
