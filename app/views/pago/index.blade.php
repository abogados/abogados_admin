@extends('layout.base_formularios')

@section('titulo')
  <h4><b>Pagos</b></h4>
@stop

@section('botones_form')
  <div class="botones_form">

    @if(Session::has('expediente_id'))

    <div style="float:left; text-align: left;">
        <h5><b>Expediente:</b></h5>
        Car&aacute;tula: <b>{{ $expediente_datos->caratula }}</b>
        | N&uacute;mero: <b>{{ $expediente_datos->numero==''?'-':$expediente_datos->numero }}</b>
        | Juzgado: <b>{{ $expediente_datos->juzgado==''?'-':$expediente_datos->juzgado }}</b></h5>
    </div>

    {{ Form::button('Volver a Expedientes', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/expedientes/index'")) }}

    @endif

    {{ Form::button('Nuevo', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/pagos/crear'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'pagos/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('pago.buscador')

    {{ Form::close() }}

    @if($errors->has())
      @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
      @endforeach
    @endif
      
    <div class="buscador_contenedor buscador_contenedor_grilla">
      @if(count($datos) == 0)
        <p>No se encontraron resultados.</p>
      @else
      <div class="CSSTableGenerator" >
        <table >
            <tr>
              <td> <b>Expediente</b> </td>
              <td> <b>Tipo de Pago</b> </td>
              <td> <b>Tipo de Operaci&oacute;n</b> </td>
              <td> <b>Monto</b> </td>
              <td> <b>Fecha Creaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td>  {{ $dato->caratula }} </td>
              <td>  {{ $dato->tipo_pago }} </td>
              <td>  {{ $dato->tipo_operacion }} </td>
              <td> ${{ $dato->monto }} </td>
              <td>  {{ $dato->creado_at }} </td>
            </tr>
            @endforeach
        </table>
      </div>
      @endif
    </div>

  </div>
@stop
