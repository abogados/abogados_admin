@extends('layout.base_formularios_usuarios')

@section('contenido')

<div>

    <br style="clear:both;" />

    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'usuarios/modificar_gf/'.$usuario->id, 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('gf[0][nombre]', 'Nombre', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[0][nombre]', Input::old('gf[0][nombre]') ? Input::old('gf[0][nombre]') : '', array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('gf[0][apellido]', 'Apellido', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[0][apellido]', Input::old('gf[0][apellido]') ? Input::old('gf[0][apellido]') : '', array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('gf[0][parentesco]', 'Parentesco', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('gf[0][parentesco]',
                array('' => 'Seleccione...',
                'Conyuge' => 'Conyuge',
                'Hijo soltero menor de 21 años' => 'Hijo soltero menor de 21 años',
                'Hijo soltero de 21 a 25 años cursando estudios regulares' => 'Hijo soltero de 21 a 25 años cursando estudios regulares',
                'Hijo de conyuge, soltero menor de 21 años' => 'Hijo de conyuge, soltero menor de 21 años',
                'Hijo de conyuge, soltero de 21 a 25 años cursando estudios regulares' => 'Hijo de conyuge, soltero de 21 a 25 años cursando estudios regulares',
                'Menor bajo guarda o tutela' => 'Menor bajo guarda o tutela',
                'Hijo Discapacitado' => 'Hijo Discapacitado',
                'Otros' => 'Otros'
                ), null, array('class' => 'form-control texto_largo')) }}
        </div>

        {{ Form::label('gf[0][dni]', 'DNI', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[0][dni]', Input::old('gf[0][dni]') ? Input::old('gf[0][dni]') : '', array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    </div>

    <hr />

    <div class="form-group">
        {{ Form::label('gf[1][nombre]', 'Nombre', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[1][nombre]', Input::old('gf[1][nombre]') ? Input::old('gf[1][nombre]') : '', array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('gf[1][apellido]', 'Apellido', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[1][apellido]', Input::old('gf[1][apellido]') ? Input::old('gf[1][apellido]') : '', array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('gf[1][parentesco]', 'Parentesco', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('gf[1][parentesco]',
                array('' => 'Seleccione...',
                'Conyuge' => 'Conyuge',
                'Hijo soltero menor de 21 años' => 'Hijo soltero menor de 21 años',
                'Hijo soltero de 21 a 25 años cursando estudios regulares' => 'Hijo soltero de 21 a 25 años cursando estudios regulares',
                'Hijo de conyuge, soltero menor de 21 años' => 'Hijo de conyuge, soltero menor de 21 años',
                'Hijo de conyuge, soltero de 21 a 25 años cursando estudios regulares' => 'Hijo de conyuge, soltero de 21 a 25 años cursando estudios regulares',
                'Menor bajo guarda o tutela' => 'Menor bajo guarda o tutela',
                'Hijo Discapacitado' => 'Hijo Discapacitado',
                'Otros' => 'Otros'
                ), null, array('class' => 'form-control texto_largo')) }}
        </div>

        {{ Form::label('gf[1][dni]', 'DNI', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[1][dni]', Input::old('gf[1][dni]') ? Input::old('gf[1][dni]') : '', array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    </div>

    <hr />

    <div class="form-group">
        {{ Form::label('gf[2][nombre]', 'Nombre', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[2][nombre]', Input::old('gf[2][nombre]') ? Input::old('gf[2][nombre]') : '', array('class' => 'form-control', 'size' => '70')) }}
        </div>

        {{ Form::label('gf[2][apellido]', 'Apellido', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[2][apellido]', Input::old('gf[2][apellido]') ? Input::old('gf[2][apellido]') : '', array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('gf[2][parentesco]', 'Parentesco', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('gf[2][parentesco]',
                array('' => 'Seleccione...',
                'Conyuge' => 'Conyuge',
                'Hijo soltero menor de 21 años' => 'Hijo soltero menor de 21 años',
                'Hijo soltero de 21 a 25 años cursando estudios regulares' => 'Hijo soltero de 21 a 25 años cursando estudios regulares',
                'Hijo de conyuge, soltero menor de 21 años' => 'Hijo de conyuge, soltero menor de 21 años',
                'Hijo de conyuge, soltero de 21 a 25 años cursando estudios regulares' => 'Hijo de conyuge, soltero de 21 a 25 años cursando estudios regulares',
                'Menor bajo guarda o tutela' => 'Menor bajo guarda o tutela',
                'Hijo Discapacitado' => 'Hijo Discapacitado',
                'Otros' => 'Otros'
                ), null, array('class' => 'form-control texto_largo')) }}
        </div>

        {{ Form::label('gf[2][dni]', 'DNI', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('gf[2][dni]', Input::old('gf[2][dni]') ? Input::old('gf[2][dni]') : '', array('class' => 'form-control', 'maxlength' => '8')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Modificar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/usuarios/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>

@stop
