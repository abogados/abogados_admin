<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('titulo', 'T&iacute;tulo', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('titulo', Input::old('titulo'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('numero', 'Nro. Expediente', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('numero', Input::old('numero'), array('class' => 'buscador_control', 'size' => '70')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('tipo_proceso', 'Tipo de Proceso', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('tipo_proceso',
              array(''    => 'Todos',
              'Tipo 1'    => 'Tipo 1',
              'Tipo 2'    => 'Tipo 2'), null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="buscador_form_group">
    {{ Form::label('created_at_desde', 'Fecha Desde', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
    <div class="col-sm-10 buscador_col_input">
        {{ Form::text('escritos__created_at_desde', Input::old('created_at_desde'), 
            array('type' => 'text', 'maxlength' => '10', 
                'class' => 'buscador_control datepicker',
                'placeholder' => 'Click aquí para seleccionar fecha.')) }}
        <script type="text/javascript">
            $(function(){
               $('.datepicker').datepicker({
                  format: 'dd-mm-yyyy'
                });
            });
        </script>
    </div>
  </div>
  <div class="buscador_form_group">
    {{ Form::label('escritos__created_at_hasta', 'Fecha Hasta', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
    <div class="col-sm-10 buscador_col_input">
        {{ Form::text('created_at_hasta', Input::old('created_at_hasta'), 
            array('type' => 'text', 'maxlength' => '10', 
                'class' => 'buscador_control datepicker',
                'placeholder' => 'Click aquí para seleccionar fecha.')) }}
        <script type="text/javascript">
            $(function(){
               $('.datepicker').datepicker({
                  format: 'dd-mm-yyyy'
                });
            });
        </script>
    </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('escritos__estado', 'Estado', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('escritos__estado',
                array(''=>'Todos',
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo'
                ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />
  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
            'onClick' => "location.href='/escritos/index'")) }}
    </div>
  </div>
</div>
