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

    @if(Session::has('expediente_id'))

    <div>
        <h5><b>Expediente:</b></h5>
        <h5>Car&aacute;tula: <b>{{ $expediente_datos->caratula }}</b></h5>
        <h5>N&uacute;mero: <b>{{ $expediente_datos->numero==''?'-':$expediente_datos->numero }}</b></h5>
        <h5>Juzgado: <b>{{ $expediente_datos->juzgado==''?'-':$expediente_datos->juzgado }}</b></h5>
    </div>

    @endif

    {{ Form::open(array('url' => 'pagos/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        @if(Session::has('expediente_id'))

        {{ Form::hidden('tipo_pago', 'Ingreso', array('id' => 'tipo_pago', 'class' => 'form-control')) }}

        @else

        {{ Form::label('tipo_pago','Tipo de Pago',array('id'=>'','class'=>'col-sm-2 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('tipo_pago',
                array(''=>'Seleccione...',
                    'Ingreso'      => 'Ingreso',
                    'Egreso'      => 'Egreso'
                    ), null, array('class' => 'form-control', 'onChange=mostrar_tipo_operacion(this.value)')) }}
        </div>

        @endif

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

        @if(!Session::has('expediente_id'))

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

        @endif
    </div>

    @if(Session::has('expediente_id'))

    {{ Form::hidden('expediente_id', Session::get('expediente_id'), array('id' => 'expediente_id', 'class' => 'form-control')) }}

    @else

    <div class="form-group" id="expediente_contenedor">
        {{ Form::label('expediente_id', 'Expediente', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('expediente_id',$expedientes, null, array('class' => 'form-control')) }}
        </div>
    </div>

    @endif


    <div class="form-group">
        {{ Form::label('monto', 'Monto ($)', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('monto', Input::old('monto'), array('class' => 'form-control texto_corto_20', 'placeholder' => '0.00')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}

            @if(Session::has('expediente_id'))

            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/pagos/index/$exped_id'")) }}

            @else

            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/pagos/index/a'")) }}

            @endif
        </div>
    </div>

    {{ Form::close() }}

</div>

<script type="text/javascript">
    function mostrar_tipo_operacion(tipo_pago){

        if($('#expediente_contenedor').length) {
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
        }

        return false;
    }

    validar_campos_form();
    mostrar_tipo_operacion('');
</script>

@stop
