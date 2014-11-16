@extends('layout.base_formularios')

@section('titulo')
    <h5>Agregar Nuevo Pago</h5>
@stop

@section('contenido')

<div>
        
    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'pagos/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('expediente_id', 'Expediente', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('expediente_id',$expedientes, null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('tipo_pago','Tipo de Pago',array('id'=>'','class'=>'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('tipo_pago',
                array(''=>'Seleccione...',
                    'Tipo 1'      => 'Tipo 1',
                    'Tipo 2'      => 'Tipo 2',
                    'Tipo 3'      => 'Tipo 3'
                    ), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('tipo_operacion','Tipo de Operaci&oacute;n',array('id'=>'','class'=>'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('tipo_operacion',
                array(''=>'Seleccione...',
                    'Tipo Op 1'      => 'Tipo Op 1',
                    'Tipo Op 2'      => 'Tipo Op 2',
                    'Tipo Op 3'      => 'Tipo Op 3'
                    ), null, array('class' => 'form-control')) }}
        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label('monto', 'Monto ($)', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('monto', Input::old('monto'), array('class' => 'form-control texto_corto')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/pagos/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop
