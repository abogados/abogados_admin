@extends('layout.base_dashboard')

@section('titulo')
  Detalle del Usuario
@stop

@section('contenido')

  @foreach($datos as $dato)
    <p>$dato->nombre</p>
    <p>$dato->apellido</p>
  @endforeach

@stop
