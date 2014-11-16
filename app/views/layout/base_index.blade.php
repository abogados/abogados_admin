<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.head')
</head>
 
<body>

  <div class='contenedor_azul'>
    @yield('titulo')
  </div>

  <div class='contenedor_separador'>

  </div>

  <div class='contenedor_azul'>

    @yield('mensajes_error')
    
    @yield('botones_form')

    @yield('contenido')
   
  </div>

  <div class='contenedor_separador'>
    &nbsp;
  </div>

  <div class='contenedor_azul'>
    @include('includes.footer')
  </div>

</body>
</html>
