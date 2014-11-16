@extends('layout.base_formularios')

@section('titulo')
    <h5>Agregar Nuevo Cliente</h5>
@stop

@section('contenido')

  <div>

    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif
    
    {{ Form::open(array('url' => 'clientes/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('nombre', Input::old('nombre'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('apellido', 'Apellido', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('apellido', Input::old('apellido'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('dni', 'DNI', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('dni', Input::old('dni'), array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('domicilio', 'Domicilio', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('domicilio', Input::old('domicilio'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('email', 'E-mail', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('localidad', 'Localidad', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('localidad', Input::old('localidad'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('provincia', 'Provincia', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('provincia',
                array(''=>'Seleccione...',
                'Buenos Aires'  =>'Buenos Aires',
                'Catamarca'     =>'Catamarca',
                'Chaco'         =>'Chaco',
                'Chubut'        =>'Chubut',
                'Cordoba'       =>'Cordoba',
                'Corrientes'    =>'Corrientes',
                'Entre Rios'    =>'Entre Rios',
                'Formosa'       =>'Formosa',
                'Jujuy'         =>'Jujuy',
                'La Pampa'      =>'La Pampa',
                'La Rioja'      =>'La Rioja',
                'Mendoza'       =>'Mendoza',
                'Misiones'      =>'Misiones',
                'Neuquen'       =>'Neuquen',
                'Rio Negro'     =>'Rio Negro',
                'Salta'         =>'Salta',
                'San Juan'      =>'San Juan',
                'San Luis'      =>'San Luis',
                'Santa Cruz'    =>'Santa Cruz',
                'Santa Fe'      =>'Santa Fe',
                'Santiago Del Estero' =>'Santiago del Estero',
                'Tierra Del Fuego' =>'Tierra del Fuego',
                'Tucuman'       =>'Tucuman'
            ), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('telefono', 'Telefono', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('telefono', Input::old('telefono'), array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('celular', 'Celular', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('celular', Input::old('celular'), array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('estado', 'Estado', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo'), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/clientes/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

  </div>

@stop
