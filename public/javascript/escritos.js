// Select Tipo Proceso
function tipos_procesos_cargar(){

    var tipo_proceso_id_hidden = $("#expediente_tipo_proceso_id").val();

    $.ajax({
        url: '/escritos/buscar_tipos_procesos',
        type: 'POST',
        data: {tipo_proceso_id:tipo_proceso_id_hidden},
        dataType: 'JSON',
        beforeSend: function() {
           $("#tipos_procesos_contenedor").html('Buscando Tipos de Procesos...');
        },
        error: function() {
           $("#tipos_procesos_contenedor").html('<div> Ha surgido un error al intentar obtener los Tipos de Procesos. </div>');
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#tipos_procesos_contenedor").html(respuesta);
           } else {
              $("#tipos_procesos_contenedor").html('<div> No hay ningún Tipo de Proceso. </div>');
           }
        }
     });

    return false;   
}

// Select Tipo Proceso
function tipo_proceso_onchange(id){
    var tipo_proceso_id_input = '';

    if(id == ''){
      tipo_proceso_id_input = $("#expediente_tipo_proceso_id").val();
    }
    else{
      tipo_proceso_id_input = id;
    }

    $.ajax({
        url: '/escritos/buscar_modelos_listado',
        type: 'POST',
        data: {tipo_proceso_id: tipo_proceso_id_input},
        dataType: 'JSON',
        beforeSend: function() {
           $("#modelos_contenedor").html('Buscando Modelos...');
        },
        error: function() {
           $("#modelos_contenedor").html('<div> Ha surgido un error al intentar obtener los Modelos. </div>');
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#modelos_contenedor").html(respuesta);

              var id = $("#tipo_proceso_id").val();

              if(id == '') {
              	$("#codigos_contenedor").html('');
              	$("#codigos_contenedor").hide();
              	$("#escrito_generado").html('');
              	$("#escrito_generado").hide();
              }
              else{
              	$("#codigos_contenedor").html('');
              	$("#codigos_contenedor").show();
              	$("#escrito_generado").html('');
              	$("#escrito_generado").show();
              }

           } else {
              $("#modelos_contenedor").html('<div> No hay ningún Modelo para ese Tipo de Proceso. </div>');
           }
        }
     });

    return false;   
}

//Select Modelos
function modelo_id_onchange(modelo_id){
    //var info = new Array();
    var modelo_id_input     = modelo_id;
    var tipo_proceso_input  = $("#tipo_proceso").val();

    $.ajax({
        url: '/escritos/buscar_modelo_codigos',
        type: 'POST',
        data: {modelo_id:modelo_id_input, tipo_proceso:tipo_proceso_input},
        dataType: 'JSON',
        beforeSend: function() {
           $("#codigos_contenedor").html('Buscando Còdigos...');
        },
        error: function() {
           $("#codigos_contenedor").html('<div> Ha surgido un error al intentar obtener los Còdigos del Modelo. </div>');
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#codigos_contenedor").html(respuesta);

              if(modelo_id == '') {
              	$("#escrito_generado").html('');
              	$("#escrito_generado").hide();
              }
              else{
              	$("#escrito_generado").html('');
              	$("#escrito_generado").show();
              }
           } else {
              $("#codigos_contenedor").html('<div> No hay ningún Código disponible para ese Modelo. </div>');
           }
        }
     });

    return false;
}

//Generar Escrito desde los códigos y un modelo seleccionado.
function generar_escrito_onclick(){

    var codigos = obtener_post_recursivo_pipes('codigos_contenedor');

    //var info = new Array();
    var modelo_id_select     = $("#modelo_id").val();
    var tipo_proceso_select  = $("#tipo_proceso").val();

    $.ajax({
        url: '/escritos/generar_escrito_reemplazo_codigos',
        type: 'POST',
        data: {modelo_id:modelo_id_select, tipo_proceso:tipo_proceso_select, codigos_modelo:codigos},
        dataType: 'JSON',
        beforeSend: function() {
           $("#escrito_generado").html('Generando el escrito...');
           $("#btnConfirmar").attr('disabled', true);
        },
        error: function() {
           $("#escrito_generado").html('<div> Ha surgido un error al intentar Generar el Escrito. </div>');
           $("#btnConfirmar").attr('disabled', true);
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#escrito_generado").html(respuesta);
              $("#btnConfirmar").attr('disabled', false);
           } else {
              $("#escrito_generado").html('<div> No se pudo generar el Escrito. </div>');
              $("#btnConfirmar").attr('disabled', true);
           }
        }
     });

    return false;
}

// Cargar Pantalla Importacion de Escritos
function importacion_cargar(){
    var expediente_id_input = $('#expediente_id').val();

    $.ajax({
        url: '/escritos/importar',
        type: 'POST',
        data: {expediente_id:expediente_id_input},
        dataType: 'JSON',
        beforeSend: function() {
           $("#importaciones").html('Cargando Form de Importación...');
        },
        error: function() {
           $("#importaciones").html('<div> Ha surgido un error al intentar cargar el Form de Importación. </div>');
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#importaciones").html(respuesta);
           } else {
              $("#importaciones").html('<div> No hay ningún Form de Importación para cargar. </div>');
           }
        }
     });

    return false;   
}

//Capa Flotante
$(document).ready(function(){
    $("#btnImportar").click(function() {
        $("#importaciones").dialog({
            width: 590,
            height: 250,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
        });
    });
});

function init() {
  $("#btnConfirmar").attr('disabled', true);
}
