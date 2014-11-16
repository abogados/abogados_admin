@extends('layout.base_formularios')

@section('titulo')
  <h5>Pagos</h5>
@stop

@section('botones_form')
  <div class="botones_form">
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
              <td> <b>Nro. Expediente</b> </td>
              <td> <b>Tipo de Pago</b> </td>
              <td> <b>Tipo de Operaci&oacute;n</b> </td>
              <td> <b>Monto</b> </td>
              <td> <b>Fecha Creaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td>  {{ $dato->numero }} </td>
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
