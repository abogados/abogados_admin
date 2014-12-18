<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.head')
</head>
 
<body>

  <div class='contenedor_azul'>

    @include('includes.usuario_logueado')

    <div class='titulo_home_dashboard'>
        <div class='logo'><img src="/images/logo.png" height="55" /></div>
        <h4>LawSie</h4>
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
