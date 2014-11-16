<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.head')
</head>
 
<body>

  <div class='contenedor_azul'>

    @include('includes.usuario_logueado')

    <div class='titulo_home_dashboard'>
        <h5>:: Estudio Abogados ::</h5>
        @yield('titulo')
    </div>

  </div>

  <div class='contenedor_separador'>
    @yield('mensajes_error')
  </div>

  <div class='contenedor_azul'>

    @yield('botones_form')

    @section('contenido')
      <p>Seleccione una opci&oacute;n del Men&uacute;.</p>
    @show
   
  </div>

  <div class='contenedor_separador'>
    &nbsp;
  </div>

  <div class='contenedor_azul'>
    @include('includes.footer')
  </div>

</body>
</html>
