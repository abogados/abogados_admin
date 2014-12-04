<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('tipo_pago','Tipo de Pago',array('id'=>'','class'=>'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('tipo_pago',
              array(''=>'Seleccione...',
                  'Ingreso'      => 'Ingreso',
                  'Egreso'      => 'Egreso'
                  ), null, array('class' => 'buscador_control', 'onChange=mostrar_tipo_operacion(this.value)')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('tipo_operacion','Tipo de Operaci&oacute;n',array('id'=>'','class'=>'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input" id="tipo_operacion_ingreso">
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
                  ), null, array('class' => 'buscador_control', 'id' => 'tipo_operacion_ing')) }}
      </div>

      <div class="col-sm-10 buscador_col_input" id="tipo_operacion_egreso">
          {{ Form::select('tipo_operacion_egr',
              array(''=>'Seleccione...',
                  'Agua'      => 'Agua',
                  'Gas'      => 'Gas',
                  'Luz'      => 'Luz',
                  'Teléfono'      => 'Teléfono',
                  'Otro'      => 'Otro'
                  ), null, array('class' => 'buscador_control', 'id' => 'tipo_operacion_egr')) }}
      </div>
  </div>
  <div class="buscador_form_group" id="expediente_contenedor">
      {{ Form::label('expediente_id', 'Expediente', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('expediente_id', $expedientes, null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="buscador_form_group">
      {{ Form::label('monto_desde', 'Monto desde ($)', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('monto_desde', Input::old('monto_desde'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('monto_hasta', 'Monto hasta ($)', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('monto_hasta', Input::old('monto_hasta'), array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="buscador_form_group">
    {{ Form::label('created_at_desde', 'Fecha Desde', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
    <div class="col-sm-10 buscador_col_input">
        {{ Form::text('created_at_desde', Input::old('created_at_desde'), 
            array('type' => 'text', 'maxlength' => '10', 
                'class' => 'buscador_control datepicker',
                'placeholder' => 'Click aquí para seleccionar fecha.')) }}
    </div>
  </div>
  <div class="buscador_form_group">
    {{ Form::label('created_at_hasta', 'Fecha Hasta', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
    <div class="col-sm-10 buscador_col_input">
        {{ Form::text('created_at_hasta', Input::old('created_at_hasta'), 
            array('type' => 'text', 'maxlength' => '10', 
                'class' => 'buscador_control datepicker',
                'placeholder' => 'Click aquí para seleccionar fecha.')) }}
    </div>
  </div>

  <br style="clear:both;" />
  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
            'onClick' => "location.href='/pagos/index'")) }}
    </div>
  </div>
</div>

<script type="text/javascript">
  function mostrar_tipo_operacion(tipo_pago){
    if(tipo_pago == '') {
        $('#tipo_operacion_ingreso').show();
        $('#tipo_operacion_ing').attr('disabled', true);
        $('#expediente_contenedor').show();
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
        $('#expediente_contenedor').hide();
        $('#tipo_operacion_egreso').show();
        $('#tipo_operacion_egr').attr('disabled', false);
    }

    return false;
  }

  validar_campos_form();
  mostrar_datepicker();
  mostrar_tipo_operacion('');
</script>
