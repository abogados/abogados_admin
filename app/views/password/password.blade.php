@extends('layout.base_formularios')

@section('titulo')
    <div class='titulo_home_index'>
        <h5>:: Estudio Abogados ::</h5>
        <h4>Cambiar mi contrase&ntilde;a</h4>
    </div>
@stop

@section('contenido')

<div>

  @if($errors->has())
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
  @endif
    
  {{ Form::open(array('url' => 'password/change-password', 'class' => 'form-horizontal', 'role' => 'form')) }}

  <div class="form-group">
      {{ Form::label('old_password', 'Contrase&ntilde;a anterior', array('class' => 'col-sm-2 col-sm-2-1  control-label')) }}
      <div class="col-sm-10 col-sm-10-30">
          {{ Form::password('old_password', array('class' => 'form-control')) }}
      </div>
  </div>

  <div class="form-group">
      {{ Form::label('password', 'Contrase&ntilde;a nueva', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
      <div class="col-sm-10 col-sm-10-30">
          {{ Form::password('password', array('class' => 'form-control')) }}
      </div>
  </div>

  <div class="form-group">
      {{ Form::label('password_repeat', 'Repetir Contrase&ntilde;a nueva', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
      <div class="col-sm-10 col-sm-10-30">
          {{ Form::password('password_repeat', array('class' => 'form-control')) }}
      </div>
  </div>

  <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
          {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
          {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
              'onClick' => "location.href='/dashboard'")) }}
      </div>
  </div>

  {{ Form::close() }}

</div>

@stop
