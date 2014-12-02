<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('nombre', Input::old('nombre'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('tipo', 'Tipo', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('tipo',
              array(''    => 'Todos',
              'Database'  => 'Database'), null, array('class' => 'buscador_control')) }}
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
            'onClick' => "location.href='/backups/index'")) }}
    </div>
  </div>
</div>

<script type="text/javascript">
    validar_campos_form();
    mostrar_datepicker();
</script>
