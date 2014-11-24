@extends('layout.base_formularios_usuarios')

@section('contenido')

<div>

    <br style="clear:both;" />

    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'usuarios/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}
    
    <div class="form-group">
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('nombre', Input::old('nombre'), array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('apellido', 'Apellido', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('apellido', Input::old('apellido'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('parentesco', 'Parentesco', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('parentesco',
                array('Titular' => 'Titular'), null, array('class' => 'form-control')) }}
        </div>

        {{ Form::label('dni', 'DNI', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('dni', Input::old('dni'), array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('domicilio', 'Domicilio', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('domicilio', Input::old('domicilio'), array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('email', 'E-mail', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('perfil', 'Perfil', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('perfil',
                array(''=>'Seleccione...',
                'Administrador' => 'Administrador',
                'Abogado Jr'    => 'Abogado Jr',
                'Abogado Sr'    => 'Abogado Sr',
                'Secretaria'    => 'Secretaria',
                'Pasante'       => 'Pasante',
                ), null, array('class' => 'form-control')) }}
        </div>

        {{ Form::label('user', 'Usuario', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('user', Input::old('user'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Contrase&ntilde;a', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::password('password', array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('estado', 'Estado', array('class' => 'col-sm-2 col-sm-2-10 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo'
                ), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/usuarios/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop
