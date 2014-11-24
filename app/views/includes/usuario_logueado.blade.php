<div class="usuario_logueado">
    <h5>
      <b>Bienvenido</b> {{ Auth::user()->user; }} <b>Perfil:</b> {{ Auth::user()->perfil; }}
    </h5>
    @if($_SERVER['REQUEST_URI'] != '/dashboard')
    {{ Form::button('Home', array('class'=>'btn btn-default btn-xs', 
          'onClick' => "location.href='/dashboard'")) }}
    @endif

    {{ Form::button('Cambiar Contrase&ntilde;a', array('class'=>'btn btn-default btn-xs', 
          'onClick' => "location.href='/password/change-password'")) }}


    {{ Form::button('Cerrar Sesi&oacute;n', array('class'=>'btn btn-default btn-xs', 
          'onClick' => "location.href='/logout'")) }}
</div>
