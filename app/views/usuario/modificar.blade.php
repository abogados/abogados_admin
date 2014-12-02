@extends('layout.base_formularios_usuarios')

@section('contenido')

<div id="msg_errores_form" class="show_error"></div>

<div>

    <br style="clear:both;" />

    {{ Form::open(array('url' => 'usuarios/modificar/'.$usuario->id, 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">   
        {{ Form::label('apellido', 'Apellido', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('apellido', Input::old('apellido') ? Input::old('apellido') : $usuario->apellido, array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('nombre', Input::old('nombre') ? Input::old('nombre') : $usuario->nombre, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('parentesco', 'Parentesco', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('parentesco',
                array('Titular' => 'Titular'), null, array('class' => 'form-control')) }}
        </div>
    
        {{ Form::label('dni', 'DNI', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('dni', Input::old('dni') ? Input::old('dni') : $usuario->dni, array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('estado_civil', 'Estado Civil', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('estado_civil',
                array(''=>'Seleccione...',
                'Casado/a'    => 'Casado/a',
                'Separado/a'  => 'Separado/a',
                'Soltero/a'   => 'Soltero/a',
                'Viudo/a'     => 'Viudo/a'
                ),  $usuario->estado_civil, array('class' => 'form-control')) }}
        </div>

        {{ Form::label('sexo', 'Sexo', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('sexo',
                array(''=>'Seleccione...',
                'Masculino'    => 'Masculino',
                'Femenino'  => 'Femenino'
                ), $usuario->sexo, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('domicilio', 'Domicilio', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('domicilio', Input::old('domicilio') ? Input::old('domicilio') : $usuario->domicilio, array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('localidad', 'Localidad', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('localidad', Input::old('localidad') ? Input::old('localidad') : $usuario->localidad, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('telefono', 'Telefono Fijo', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('telefono', Input::old('telefono') ? Input::old('telefono') : $usuario->telefono, array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('celular', 'Celular', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('celular', Input::old('celular') ? Input::old('celular') : $usuario->celular, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('fecha_nacimiento', 'Fecha de Nacimiento', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('fecha_nacimiento', Input::old('fecha_nacimiento') ? Input::old('fecha_nacimiento') : $usuario->fecha_nacimiento, 
                array('type' => 'text', 'maxlength' => '10', 
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Click aquí para seleccionar fecha.')) }}
        </div>

        {{ Form::label('profesion', 'Profesi&oacute;n', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('profesion', Input::old('profesion') ? Input::old('profesion') : $usuario->profesion, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'E-mail', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('email', Input::old('email') ? Input::old('email') : $usuario->email, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <hr />

    <div class="form-group">
        {{ Form::label('fecha_ingreso', 'Fecha de Ingreso', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('fecha_ingreso', Input::old('fecha_ingreso') ? Input::old('fecha_ingreso') : $usuario->fecha_ingreso, 
                array('type' => 'text', 'maxlength' => '10', 
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Click aquí para seleccionar fecha.')) }}
        </div>

        {{ Form::label('legajo', 'Legajo', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('legajo', Input::old('legajo') ? Input::old('legajo') : $usuario->legajo, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('perfil', 'Perfil', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('perfil',
                array(''=>'Seleccione...',
                'Administrador' => 'Administrador',
                'Abogado Jr'    => 'Abogado Jr',
                'Abogado Sr'    => 'Abogado Sr',
                'Secretaria'    => 'Secretaria',
                'Pasante'       => 'Pasante',
                ), $usuario->perfil, array('class' => 'form-control')) }}
        </div>
    
        {{ Form::label('user', 'Usuario', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('user', Input::old('user') ? Input::old('user') : $usuario->user, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Contrase&ntilde;a', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::password('password', array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('password_repet', 'Repetir Contrase&ntilde;a', array('class' => 'col-sm-2 col-sm-2-15 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::password('password_repeat', array('class' => 'form-control', 'id' => 'password_repeat', 'size' => '70', 'onChange' => 'validar_contraseña()')) }}
        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label('estado', 'Estado', array('class' => 'col-sm-2 col-sm-2-15 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo'), 
                $usuario->estado, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Modificar', array('class' => 'btn btn-default', 'id' => 'btnConfirmar')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/usuarios/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>

@stop

<script type="text/javascript">
    validar_campos_form();
</script>

<script type="text/javascript">
    validar_campos_form();
    mostrar_datepicker();
</script>
