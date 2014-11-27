@extends('layout.base_formularios')

@section('titulo')
    <h5>Modificar Cliente</h5>
@stop

@section('contenido')

<div>

    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'clientes/modificar/'.$cliente->id, 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('nombre', Input::old('nombre') ? Input::old('nombre') : $cliente->nombre, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    
        {{ Form::label('apellido', 'Apellido', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('apellido', Input::old('apellido') ? Input::old('apellido') : $cliente->apellido, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('dni', 'DNI', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('dni', Input::old('dni') ? Input::old('dni') : $cliente->dni, array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    
        {{ Form::label('domicilio', 'Domicilio', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('domicilio', Input::old('domicilio') ? Input::old('domicilio') : $cliente->domicilio, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('email', 'E-mail', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('email', Input::old('email') ? Input::old('email') : $cliente->email, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    
        {{ Form::label('localidad', 'Localidad', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('localidad', Input::old('localidad') ? Input::old('localidad') : $cliente->localidad, array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('provincia', 'Provincia', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
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
            ), $cliente->provincia, array('class' => 'form-control')) }}
        </div>
    
        {{ Form::label('telefono', 'Telefono', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('telefono', Input::old('telefono') ? Input::old('telefono') : $cliente->telefono, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('celular', 'Celular', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('celular', Input::old('celular') ? Input::old('celular') : $cliente->celular, array('class' => 'form-control')) }}
        </div>
    
        {{ Form::label('estado', 'Estado', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo'), $cliente->estado, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Modificar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/clientes/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>

@stop
