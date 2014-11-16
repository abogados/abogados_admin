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