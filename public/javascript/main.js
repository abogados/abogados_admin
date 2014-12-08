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
    if($('#nombre'))        $('#nombre').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    if($('#apellido'))      $('#apellido').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    if($('#profesion'))     $('#profesion').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    if($('#localidad'))     $('#localidad').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    if($('#caratula'))      $('#caratula').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou-,.');
    if($('#apenom'))        $('#apenom').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
    if($('#descripcion'))   $('#descripcion').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');
   
    //Para escribir solo numeros    
    if($('#dni'))           $('#dni').validCampoFranz('0123456789');
    if($('#celular'))       $('#celular').validCampoFranz('0123456789');
    if($('#telefono'))      $('#telefono').validCampoFranz('0123456789');
    if($('#legajo'))        $('#legajo').validCampoFranz('0123456789');
    if($('#numero'))        $('#numero').validCampoFranz('0123456789'); // se refiere a Nro Expediente
    if($('#hora_alarma'))   $('#hora_alarma').validCampoFranz('0123456789:'); // se refiere a Nro Expediente
    if($('#monto'))         $('#monto').validCampoFranz('0123456789.');
    if($('#monto_desde'))   $('#monto_desde').validCampoFranz('0123456789.');
    if($('#monto_hasta'))   $('#monto_hasta').validCampoFranz('0123456789.');

    //No permitir ningun tipo de caracter
    if($('#fecha_ingreso'))         $('#fecha_ingreso').validCampoFranz('');
    if($('#fecha_nacimiento'))      $('#fecha_nacimiento').validCampoFranz('');
    if($('#fecha_inicio'))          $('#fecha_inicio').validCampoFranz('');
    if($('#fecha_presentacion'))    $('#fecha_inicio').validCampoFranz('');
    if($('#fecha_finalizacion'))    $('#fecha_finalizacion').validCampoFranz('');
    if($('#fecha_desde'))           $('#fecha_desde').validCampoFranz('');
    if($('#fecha_hasta'))           $('#fecha_hasta').validCampoFranz('');
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

function encode_especiales(valor){
    while(valor.indexOf("+")>-1){
        valor=valor.replace("+", "%2B");
    }
    while(valor.indexOf("/")>-1){
        valor=valor.replace("/", "%2F");
    }
    
    return valor;
}

function obtener_post_recursivo_pipes(padre){
    var datos="";
    
    try{
        var objeto_rec = document.getElementById(padre);
    }
    catch(e){}
    var campos=objeto_rec.getElementsByTagName("INPUT");
    for (x=0;x<campos.length;x++){
        datos += campos[x].id+"="+encode_especiales(escape(campos[x].value))+"||";
    }
    
    var selectores=objeto_rec.getElementsByTagName("SELECT");
    for (x=0;x<selectores.length;x++){
        datos += selectores[x].id+"="+encode_especiales(escape(selectores[x].value))+"||";
    }
    
    return datos;
}
