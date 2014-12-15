<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('numero', 'Nro. Expediente', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('numero', Input::old('numero'), array('class' => 'buscador_control', 'size' => '70')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('juzgado', 'Juzgado', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('juzgado', Input::old('juzgado'), array('class' => 'buscador_control', 'size' => '70')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="buscador_form_group">
      {{ Form::label('caratula', 'Car&aacute;tula', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('caratula', Input::old('caratula'), array('class' => 'buscador_control', 'size' => '70')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('estado', 'Estado', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('estado',
              array(''=>'Todos',
              'Iniciado'              => 'Iniciado',
              'Archivado'             => 'Archivado',
              'Letra'                 => 'Letra',
              'Para la Firma'         => 'Para la Firma',
              'Con Sentencia Firme'   => 'Con Sentencia Firme',
              'Elevado a Cámara'      => 'Elevado a Cámara',
              'En 1ra Instancia'      => 'En 1ra Instancia',
              'En 2da Instancia'      => 'En 2da Instancia'
              ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
            'onClick' => "location.href='/expedientes/index'")) }}
    </div>
  </div>
</div>

<script type="text/javascript">
    validar_campos_form();
</script>
