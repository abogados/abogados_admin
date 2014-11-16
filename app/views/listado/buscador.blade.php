<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('tipo_modulo','Tipo de Módulo a Listar',array('id'=>'','class'=>'col-sm-2 buscador_col_label_20 control-label')) }}
      <div class="col-sm-10 buscador_col_input_20">
          {{ Form::select('tipo_modulo',
              array(''=>'Seleccione...',
                  'Empleados'     => 'Empleados',
                  'Clientes'      => 'Clientes',
                  'Expedientes'   => 'Expedientes'
                  ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Confirmar', array('class' => 'btn btn-default btn-default-azul')) }}
    </div>
  </div>
</div>
