<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('descripcion', 'Descripci&oacute;n', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('descripcion', Input::old('descripcion'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('codigo', 'C&oacute;digo', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('codigo', Input::old('codigo'), array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
            'onClick' => "location.href='/modelos/vercodigos'")) }}
    </div>
  </div>
</div>

<script type="text/javascript">
    validar_campos_form();
</script>
