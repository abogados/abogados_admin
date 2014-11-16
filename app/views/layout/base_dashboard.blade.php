<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.head')
</head>
 
<body>

  <div class='contenedor_azul'>
    
    @include('includes.usuario_logueado')

    @yield('titulo')

  </div>

  <div class='contenedor_separador'>
    &nbsp;
  </div>

  <div class='contenedor_azul'>

  
    <!-- menubar -->
    <header>
        @include('includes.header')
    </header>
    <!-- /header -->

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
