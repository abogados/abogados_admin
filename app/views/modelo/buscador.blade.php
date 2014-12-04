<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('nombre', Input::old('nombre'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('tipo_proceso','Tipo de Proceso',array('id'=>'','class'=>'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('tipo_proceso',
              array(''=>'Todos',
                  'Tipo 1'      => 'Tipo 1',
                  'Tipo 2'      => 'Tipo 2',
                  'Tipo 3'      => 'Tipo 3'
                  ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
            'onClick' => "location.href='/modelos/index'")) }}
    </div>
  </div>
</div>

<script type="text/javascript">
    validar_campos_form();
    mostrar_datepicker();
</script>
