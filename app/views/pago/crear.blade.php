@extends('layout.base_formularios')

@section('titulo')
    <h4><b>Agregar Nuevo Pago</b></h4>
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
        {{ Form::label('tipo_pago','Tipo de Pago',array('id'=>'','class'=>'col-sm-2 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('tipo_pago',
                array(''=>'Seleccione...',
                    'Ingreso'      => 'Ingreso',
                    'Egreso'      => 'Egreso'
                    ), null, array('class' => 'form-control', 'onChange=mostrar_tipo_operacion(this.value)')) }}
        </div>

        {{ Form::label('tipo_operacion','Tipo de Operaci&oacute;n',array('id'=>'','class'=>'col-sm-2 control-label')) }}
        <div class="col-sm-10 col-sm-10-30" id="tipo_operacion_ingreso">
            {{ Form::select('tipo_operacion_ing',
                array(''=>'Seleccione...',
                    'Bono de Colegio'       => 'Bono de Colegio',
                    'Bono de Ley 6059'      => 'Bono de Ley 6059',
                    'Bono de Movilidad'     => 'Bono de Movilidad',
                    'Consulta'              => 'Consulta',
                    'Fotocopias'            => 'Fotocopias',
                    'Gastos Fiscales'       => 'Gastos Fiscales',
                    'Honorarios'            => 'Honorarios',
                    'Oficios'               => 'Oficios',
                    'Tasa de Justicia'      => 'Tasa de Justicia',
                    'Traslado'              => 'Traslado',
                    'Otros'                 => 'Otros'
                    ), null, array('class'  => 'form-control', 'id' => 'tipo_operacion_ing')) }}
        </div>

        <div class="col-sm-10 col-sm-10-30" id="tipo_operacion_egreso">
            {{ Form::select('tipo_operacion_egr',
                array(''=>'Seleccione...',
                    'Agua'      => 'Agua',
                    'Gas'      => 'Gas',
                    'Luz'      => 'Luz',
                    'Teléfono'      => 'Teléfono',
                    'Otro'      => 'Otro'
                    ), null, array('class' => 'form-control', 'id' => 'tipo_operacion_egr')) }}
        </div>
    </div>

    <div class="form-group" id="expediente_contenedor">
        {{ Form::label('expediente_id', 'Expediente', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('expediente_id',$expedientes, null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('monto', 'Monto ($)', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('monto', Input::old('monto'), array('class' => 'form-control texto_corto_20', 'placeholder' => '0.00')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/pagos/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>

<script type="text/javascript">
    function mostrar_tipo_operacion(tipo_pago){

        if(tipo_pago == '') {
            $('#tipo_operacion_ingreso').show();
            $('#tipo_operacion_ing').attr('disabled', true);
            $('#expediente_contenedor').show();
            $('#expediente_id').val('');
            $('#expediente_id').attr('disabled', true);
            $('#tipo_operacion_egreso').hide();
        }
        else if(tipo_pago != '' && tipo_pago == 'Ingreso'){
            $('#tipo_operacion_ingreso').show();
            $('#tipo_operacion_ing').attr('disabled', false);
            $('#expediente_contenedor').show();
            $('#expediente_id').attr('disabled', false);
            $('#tipo_operacion_egreso').hide();
        }
        else if(tipo_pago != '' && tipo_pago == 'Egreso'){
            $('#tipo_operacion_ingreso').hide();
            $('#expediente_id').val('');
            $('#expediente_contenedor').hide();
            $('#tipo_operacion_egreso').show();
            $('#tipo_operacion_egr').attr('disabled', false);
        }

        return false;
    }

    validar_campos_form();
    mostrar_tipo_operacion('');
</script>

@stop
