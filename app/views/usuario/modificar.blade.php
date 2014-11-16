@extends('layout.base_formularios_usuarios')

@section('contenido')

<div>

    <br style="clear:both;" />

    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'usuarios/modificar/'.$usuario->id, 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('nombre', Input::old('nombre') ? Input::old('nombre') : $usuario->nombre, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('apellido', 'Apellido', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('apellido', Input::old('apellido') ? Input::old('apellido') : $usuario->apellido, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('parentesco', 'Parentesco', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('parentesco',
                array('Titular' => 'Titular'), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('dni', 'DNI', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('dni', Input::old('dni') ? Input::old('dni') : $usuario->dni, array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('domicilio', 'Domicilio', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('domicilio', Input::old('domicilio') ? Input::old('domicilio') : $usuario->domicilio, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('email', 'E-mail', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('email', Input::old('email') ? Input::old('email') : $usuario->email, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('perfil', 'Perfil', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('perfil',
                array(''=>'Seleccione...',
                'Administrador' => 'Administrador',
                'Abogado Jr'    => 'Abogado Jr',
                'Abogado Sr'    => 'Abogado Sr',
                'Secretaria'    => 'Secretaria',
                'Pasante'       => 'Pasante',
                ), $usuario->perfil, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('user', 'Usuario', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('user', Input::old('user') ? Input::old('user') : $usuario->user, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Contrase&ntilde;a', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::password('password', array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('estado', 'Estado', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo'), $usuario->estado, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Modificar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/usuarios/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>

@stop
