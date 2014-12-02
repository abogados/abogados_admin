// BEGIN Funciones para las solapas para Usuarios
$(function() {

    $('#titular').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pg = getPaginationSelectedPage($(this).attr('href'));

        $.ajax({
            url: '/usuarios/ajax/titular',
            data: '',
            success: function(data) {
                $('#titular').html(data);
            }
        });
    });

    $('#grupo_familiar').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pg = getPaginationSelectedPage($(this).attr('href'));

        $.ajax({
            url: '/usuarios/ajax/grupo_familiar',
            data: '',
            success: function(data) {
                $('#grupo_familiar').html(data);
            }
        });
    });

    if($("#usuario_id").val() != undefined) {
        // para usuarios.modificar
        var usuario_id = $("#usuario_id").val();
        // Primera carga...
        $('#titular').load('/usuarios/ajax/titular?usuario_id=' + usuario_id);
        $('#grupo_familiar').load('/usuarios/ajax/grupo_familiar?usuario_id=' + usuario_id);
    }
    else {
        // para usuarios.crear
        $('#titular').load('/usuarios/ajax/titular');
    }
});
// END Funciones para las solapas para Usuarios

function validar_campos_form(){
    //Para escribir solo letras
    $('#nombre').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    $('#apellido').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    $('#profesion').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    $('#localidad').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
   
    //Para escribir solo numeros    
    $('#dni').validCampoFranz('0123456789');    
    $('#celular').validCampoFranz('0123456789');    
    $('#telefono').validCampoFranz('0123456789');    
    $('#legajo').validCampoFranz('0123456789');    

    //No permitir ningun tipo de caracter
    $('#fecha_ingreso').validCampoFranz('');
    $('#fecha_nacimiento').validCampoFranz('');
}

function validar_contraseña() {
    var pass        = $('#password').val();
    var pass_repeat = $('#password_repeat').val();

    if(pass != '' || pass_repeat != ''){
        if(pass != pass_repeat){
            $('#msg_errores_form').html('Contraseña y Repetir Contraseña deben coincidir. Corrija por favor.');
            $('#btnConfirmar').attr('disabled', true);
            return false;
        }
        else{
            $('#msg_errores_form').html('');
            $('#btnConfirmar').attr('disabled', false);
        }
    }
}

// Parametrización para jQuery UI Datepicker
function mostrar_datepicker() {
    $('.datepicker').datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      yearRange: "-85:+0"
    });
}
