<nav class="navbar navbar-default navbar_estilos" role="navigation">
    <div class="dashboard_menu">
         
        <div id="menu1">
            @if(Auth::user()->perfil === 'Administrador')
            <span id="boton_dashboard_menu"><a href="{{ URL::route('usuarios.index') }}">Empleados</a></span>
            @endif
            <span id="boton_dashboard_menu"><a href="{{ URL::route('clientes.index') }}">Clientes</a></span>
            <span id="boton_dashboard_menu"><a href="{{ URL::route('expedientes.index') }}">Expedientes</a></span>
            <span id="boton_dashboard_menu"><a href="{{ URL::route('modelos.index') }}">Modelos</a></span>
        </div>
        <br /><br /><br /><br /><br />
        <div id="menu2">
            <span id="boton_dashboard_menu"><a href="{{ URL::route('agendas.index') }}">Agenda</a></span>
            <span id="boton_dashboard_menu"><a href="{{ URL::route('listados.index') }}">Listados</a></span>
            <span id="boton_dashboard_menu"><a href="{{ URL::route('pagos.index', array('id' => 'a')) }}">Pagos</a></span>
            <span id="boton_dashboard_menu"><a href="{{ URL::route('backups.index') }}">Backups</a></span>
        </div>

    </div><!-- /.container-fluid -->
</nav>
