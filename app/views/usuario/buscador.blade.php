<div class="buscador_contenedor">
	<div class="buscador_form_group">
	    {{ Form::label('apenom', 'Apellido y Nombre', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
	    <div class="col-sm-10 buscador_col_input">
	        {{ Form::text('apenom', Input::old('apenom'), array('class' => 'buscador_control', 'size' => '70')) }}
	    </div>
	</div>

    <div class="buscador_form_group">
        {{ Form::label('perfil', 'Perfil', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
        <div class="col-sm-10 buscador_col_input">
            {{ Form::select('perfil',
                array(''=>'Todos',
                'Administrador' => 'Administrador',
                'Abogado Jr'    => 'Abogado Jr',
                'Abogado Sr'    => 'Abogado Sr',
                'Secretaria'    => 'Secretaria',
                'Pasante'       => 'Pasante',
                ), null, array('class' => 'buscador_control')) }}
        </div>
    </div>

    <div class="buscador_form_group">
        {{ Form::label('profesion', 'Profesi&oacute;n', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
        <div class="col-sm-10 buscador_col_input">
            {{ Form::text('profesion', Input::old('profesion'), array('class' => 'buscador_control', 'size' => '70')) }}
        </div>
    </div>
	
	<br style="clear:both;" />

    <div class="buscador_form_group">
        {{ Form::label('dni', 'DNI', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
        <div class="col-sm-10 buscador_col_input">
            {{ Form::text('dni', Input::old('dni'), array('class' => 'buscador_control', 'size' => '70')) }}
        </div>
    </div>

    <div class="buscador_form_group">
        {{ Form::label('legajo', 'Legajo', array('class' => 'col-sm-2 buscador_col_label control-label')) }}
        <div class="col-sm-10 buscador_col_input">
            {{ Form::text('legajo', Input::old('legajo'), array('class' => 'buscador_control', 'size' => '70')) }}
        </div>
    </div>

    <br style="clear:both;" />

    <div class="form-group">
	    <div class="col-sm-offset-2 buscador_botones">
	        {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-default-azul')) }}
	        {{ Form::button('Reiniciar', array('class'=>'btn btn-default btn-default-azul', 
	            'onClick' => "location.href='/usuarios/index'")) }}
	    </div>
  	</div>
</div>

<script type="text/javascript">
    validar_campos_form();
    mostrar_datepicker();
</script>
