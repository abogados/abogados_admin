<div class="buscador_contenedor">
  <div class="buscador_form_group">
      {{ Form::label('descripcion', 'Descripci&oacute;n', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::text('descripcion', Input::old('titulo'), array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('tipo_evento', 'Tipo de Evento', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('tipo_evento',
              array(''=>'Seleccione...',
                'Tarea'         => 'Tarea',
                'Recordatorio'  => 'Recordatorio'
              ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>
  <div class="buscador_form_group">
      {{ Form::label('estado', 'Estado', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
      <div class="col-sm-10 buscador_col_input">
          {{ Form::select('estado',
                array(''=>'Todos',
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo'
                ), null, array('class' => 'buscador_control')) }}
      </div>
  </div>

  <br style="clear:both;" />

  <div class="buscador_form_group">
    {{ Form::label('fecha_desde', 'Fecha Desde', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
    <div class="col-sm-10 buscador_col_input">
        {{ Form::text('fecha_desde', Input::old('fecha_desde'), 
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
    {{ Form::label('escritos__fecha_hasta', 'Fecha Hasta', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
    <div class="col-sm-10 buscador_col_input">
        {{ Form::text('fecha_hasta', Input::old('fecha_hasta'), 
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

  <br style="clear:both;" />
  <br style="clear:both;" />

  <div class="form-group">
    <div class="col-sm-offset-2 buscador_botones">
        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
            'onClick' => "location.href='/agendas/index'")) }}
    </div>
  </div>
</div>
