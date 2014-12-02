<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('expediente_id', 'Expediente', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('expediente_id', $expedientes, null, array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('tipo_pago','Tipo de Pago',array('id'=>'','class'=>'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('tipo_pago',
              array(''=>'Seleccione...',
                  'Tipo 1'      => 'Tipo 1',
                  'Tipo 2'      => 'Tipo 2',
                  'Tipo 3'      => 'Tipo 3'
                  ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('tipo_operacion','Tipo de Operaci&oacute;n',array('id'=>'','class'=>'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('tipo_operacion',
              array(''=>'Seleccione...',
                  'Tipo Op 1'      => 'Tipo Op 1',
                  'Tipo Op 2'      => 'Tipo Op 2',
                  'Tipo Op 3'      => 'Tipo Op 3'
                  ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="buscador_form_group">
      {{ Form::label('monto_desde', 'Monto ($)', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('monto_desde', Input::old('monto_desde'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('monto_hasta', 'Monto ($)', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('monto_hasta', Input::old('monto_hasta'), array('class' => 'buscador_control')) }}
      </div>
  </div>
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
    {{ Form::label('escritos__created_at_hasta', 'Fecha Hasta', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
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
    validar_campos_form();
    mostrar_datepicker();
</script>
