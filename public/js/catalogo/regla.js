
$(document).ready(function(){

	var carpeta = $("#carpeta").val();


    $(".asignarregla").on('click','.label-etiqueta-eliminar', function(e) {

        var _token                  =   $('#token').val();
        var idreglaproductocliente  =   $(this).attr('data_id');
        var producto_id             =   $(this).parents('.regla-modal').attr('data_producto');
        var cliente_id              =   $(this).parents('.regla-modal').attr('data_cliente');
        var contrato_id             =   $(this).parents('.regla-modal').attr('data_contrato');
        var regla_id                =   $(this).parents('.regla-modal').attr('data_regla');

        var prefijo                 =   $(this).parents('.regla-modal').attr('data_prefijo');
        var tipo                    =   prefijo.toUpperCase();
        var color                   =   $(this).parents('.regla-modal').attr('data_color');


        $.ajax({
              type    :   "POST",
              url     :   carpeta+"/ajax-eliminar-regla",
              data    :   {
                            _token                              : _token,
                            idreglaproductocliente              : idreglaproductocliente
                          },
            success: function (data) {
                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;
                if(error==false){
                    alertajax(mensaje);
                    actualizar_et(color,tipo,prefijo,producto_id,cliente_id,contrato_id,_token,carpeta);
                    actualizar_etm(color,tipo,prefijo,producto_id,cliente_id,contrato_id,_token,carpeta);
                }else{
                    alerterrorajax(mensaje); 
                }
            },
            error: function (data) {
                error500(data);
            }
        });

    });



    $(".asignarregla").on('click','.btn-regla-modal', function(e) {

        var _token              =   $('#token').val();
        var producto_id         =   $(this).parents('.regla-modal').attr('data_producto');
        var cliente_id          =   $(this).parents('.regla-modal').attr('data_cliente');
        var contrato_id          =   $(this).parents('.regla-modal').attr('data_contrato');
        var regla_id            =   $(this).parents('.input-group-btn').siblings('#regla_id').val();
        var prefijo             =   $(this).parents('.regla-modal').attr('data_prefijo');
        var tipo                =   prefijo.toUpperCase();
        var color               =   $(this).parents('.regla-modal').attr('data_color');


        if(regla_id==''){alerterrorajax("Seleccione una regla");return false;}

        $.ajax({
              type    :   "POST",
              url     :   carpeta+"/ajax-agregar-regla",
              data    :   {
                            _token          : _token,
                            producto_id     : producto_id,
                            cliente_id      : cliente_id,
                            contrato_id     : contrato_id,
                            regla_id        : regla_id,
                            tipo            : tipo,
                          },
            success: function (data) {

                JSONdata     = JSON.parse(data);
                error        = JSONdata[0].error;
                mensaje      = JSONdata[0].mensaje;
                if(error==false){
                    alertajax(mensaje);
                    actualizar_et(color,tipo,prefijo,producto_id,cliente_id,contrato_id,_token,carpeta);
                    actualizar_etm(color,tipo,prefijo,producto_id,cliente_id,contrato_id,_token,carpeta);
                }else{
                    alerterrorajax(mensaje); 
                }
            },
            error: function (data) {
                error500(data);
            }
        });

    });


    $(".asignarregla").on('click','.label-etiqueta', function(e) {

        $(this).popover({
            trigger: 'click',
            html: true,  // must have if HTML is contained in popover
            // get the title and conent
            title: function() {
                var data_sw         = $(this).attr('data_sw');
                var data_id         = $(this).attr('data_id');
                if(data_sw == '0'){
                    var producto_id         =   $(this).parents('.fila_regla').attr('data_producto');
                    var cliente_id          =   $(this).parents('.fila_regla').attr('data_cliente');
                    var idpopover           =   '.po-detalle'+data_id;          
                }else{
                    var producto_id         =   $(this).parents('.regla-modal').attr('data_producto');
                    var cliente_id          =   $(this).parents('.regla-modal').attr('data_cliente');
                    var idpopover           =   '.po-detalle-modal'+data_id;
                }
                var _token          = $('#token').val();
                var regla_id        = $(this).attr('data_regla');

                detalle_regla_popover(producto_id,cliente_id,regla_id,_token);
                return $('.po-title').html(); 
            },
            content: function() {
                return $('.po-body').html();
            },
            container: 'body',
            placement: 'top'
        });


    }); 


    $('.label-etiqueta').popover({
        trigger: 'click',
        html: true,  // must have if HTML is contained in popover
        // get the title and conent
        title: function() {
            var data_sw         = $(this).attr('data_sw');
            var data_id         = $(this).attr('data_id');
            if(data_sw == '0'){
                var producto_id         =   $(this).parents('.fila_regla').attr('data_producto');
                var cliente_id          =   $(this).parents('.fila_regla').attr('data_cliente');
                var idpopover           =   '.po-detalle'+data_id;          
            }else{
                var producto_id         =   $(this).parents('.regla-modal').attr('data_producto');
                var cliente_id          =   $(this).parents('.regla-modal').attr('data_cliente');
                var idpopover           =   '.po-detalle-modal'+data_id;
            }
            var _token          = $('#token').val();
            var regla_id        = $(this).attr('data_regla');

            detalle_regla_popover(producto_id,cliente_id,regla_id,_token);
            return $('.po-title').html(); 
        },
        content: function() {
            return $('.po-body').html();
        },
        container: 'body',
        placement: 'top'
    });


    /******************************************************** AJAX MODAL **********************************************************/

    $(".asignarregla").on('click','.popover-edit', function(e) {

        var _token          = $('#token').val();
        var producto_id     = $(this).parents('.fila_regla').attr('data_producto');
        var cliente_id      = $(this).parents('.fila_regla').attr('data_cliente');
        var contrato_id     = $(this).parents('.fila_regla').attr('data_contrato');


        var nombre          = $(this).attr('data_nombre');
        var nombreselect    = $(this).attr('data_nombreselect');
        var tipo            = $(this).attr('data_tipo');
        var prefijo         = $(this).attr('data_prefijo');
        var color           = $(this).attr('data_color');
        var color_modal     = $(this).attr('data_color_modal');
        limpiar_colores_modal();
        $(".colored-header").addClass(color_modal);
        cerrar_todos_popover(e);

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-detalle",
            data    :   {
                            _token          : _token,
                            producto_id     : producto_id,
                            cliente_id      : cliente_id,
                            contrato_id     : contrato_id,
                            nombre          : nombre,
                            nombreselect    : nombreselect,
                            tipo            : tipo,
                            prefijo         : prefijo,
                            color           : color,
                        },
            success: function (data) {
                $('.modal-negociacion-container').html(data);
                $('#modal-negociacion').niftyModal();
            },
            error: function (data) {
                error500(data);
            }
        });

    });






    $(".asignarregla").on('click','#btnbuscar', function(e) {

        var cliente              =   $('#cliente').val().trim();
        var tipodocumento_id     =   $('#tipodocumento_id').val();
        var sw                   =   0;

        
    });

});


function detalle_regla_popover(producto_id,cliente_id,regla_id,_token){


    var carpeta = $("#carpeta").val();
    $.ajax({
          type    :     "POST",
          async   :     false,
          url     :     carpeta+"/ajax-detalle-regla",
          data    :     {
                            _token          : _token,
                            producto_id     : producto_id,
                            cliente_id      : cliente_id,
                            regla_id        : regla_id
                        },
            success: function (data) {
                $('.po-regla').html(data);
            },
            error: function (data) {
                error500(data);
            }
    });

}


function actualizar_et(color,tipo,prefijo,producto_id,cliente_id,contrato_id,_token,carpeta){

    var content = $('.et'+prefijo+producto_id+cliente_id);

    $.ajax({
          type    :   "POST",
          url     :   carpeta+"/ajax-actualizar-lista-regla",
          data    :   {
                        _token          : _token,
                        producto_id     : producto_id,
                        cliente_id      : cliente_id,
                        contrato_id     : contrato_id,
                        tipo            : tipo,
                        color           : color,
                      },
        success: function (data) {
            $(content).html(data);
        },
        error: function (data) {
            error500(data);
        }
    });

}

function actualizar_etm(color,tipo,prefijo,producto_id,cliente_id,contrato_id,_token,carpeta){

    var content = $('.etm'+prefijo+producto_id+cliente_id);

    $.ajax({
          type    :   "POST",
          url     :   carpeta+"/ajax-actualizar-modal-regla",
          data    :   {
                        _token          : _token,
                        producto_id     : producto_id,
                        cliente_id      : cliente_id,
                        contrato_id     : contrato_id,
                        tipo            : tipo,
                        color           : color,
                      },
        success: function (data) {
            $(content).html(data);
        },
        error: function (data) {
            error500(data);
        }
    });

}

function cerrar_todos_popover(e){

    /******* cerrar todos los popover ********/
    $('[data-toggle="popovers"]').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
    /******************************************/
}

function limpiar_colores_modal(){
    $(".colored-header").removeClass('colored-header-success');
    $(".colored-header").removeClass('colored-header-primary');
    $(".colored-header").removeClass('colored-header-warning');
    $(".colored-header").removeClass('colored-header-danger');
}