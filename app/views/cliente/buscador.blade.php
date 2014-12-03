<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('apenom', 'Apellido y Nombre', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('apenom', Input::old('apenom'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('dni', 'DNI', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('dni', Input::old('dni'), array('class' => 'buscador_control', 'maxlength' => '8')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
            'onClick' => "location.href='/clientes/index'")) }}
    </div>
  </div>
</div>

<script type="text/javascript">
    validar_campos_form();
    mostrar_datepicker();
</script>
