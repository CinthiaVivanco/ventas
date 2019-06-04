
    /******************************************************** NEGOCIACION **********************************************************/

    $(".asignarregla").on('click','.popover-negociacion', function(e) {

        var _token          = $('#token').val();
        var producto_id     = $(this).parents('.fila_regla').attr('data_producto');
        var cliente_id      = $(this).parents('.fila_regla').attr('data_cliente');
        var nombre          = 'NEGOCIACION';
        var nombreselect    = 'negociacion';
        var tipo            = 'NEG';
        var prefijo         = 'neg';
        var color           = 'success';

        cerrar_todos_popover(e);

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-detalle",
            data    :   {
                            _token          : _token,
                            producto_id     : producto_id,
                            cliente_id      : cliente_id,
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



    /******************************************************** PRECIO OV *************************************************************/

    $(".asignarregla").on('click','.popover-precio-ov', function(e) {

        var _token          = $('#token').val();
        var producto_id     = $(this).parents('.fila_regla').attr('data_producto');
        var cliente_id      = $(this).parents('.fila_regla').attr('data_cliente');
        var nombre          = 'PRECIO';
        var nombreselect    = 'precio';
        var tipo            = 'POV';
        var prefijo         = 'pov';
        var color           = 'primary';


        cerrar_todos_popover(e);

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-detalle",
            data    :   {
                            _token          : _token,
                            producto_id     : producto_id,
                            cliente_id      : cliente_id,
                            nombre          : nombre,
                            nombreselect    : nombreselect,
                            tipo            : tipo,
                            prefijo         : prefijo,
                            color           : color,
                        },
            success: function (data) {
                $('.modal-precio-ov-container').html(data);
                $('#modal-precio-ov').niftyModal();
            },
            error: function (data) {
                error500(data);
            }
        });

    });


   /******************************************************** PRECIO NC *************************************************************/

    $(".asignarregla").on('click','.popover-precio-nc', function(e) {

        var _token          = $('#token').val();
        var producto_id     = $(this).parents('.fila_regla').attr('data_producto');
        var cliente_id      = $(this).parents('.fila_regla').attr('data_cliente');
        var nombre          = 'NOTA CREDITO';
        var nombreselect    = 'nota credito';
        var tipo            = 'PNC';
        var prefijo         = 'pnc';
        var color           = 'warning';


        cerrar_todos_popover(e);

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-detalle",
            data    :   {
                            _token          : _token,
                            producto_id     : producto_id,
                            cliente_id      : cliente_id,
                            nombre          : nombre,
                            nombreselect    : nombreselect,
                            tipo            : tipo,
                            prefijo         : prefijo,
                            color           : color,
                        },
            success: function (data) {
                $('.modal-precio-nc-container').html(data);
                $('#modal-precio-nc').niftyModal();
            },
            error: function (data) {
                error500(data);
            }
        });

    });


   /******************************************************** CUPON *************************************************************/

    $(".asignarregla").on('click','.popover-cupon', function(e) {

        var _token          = $('#token').val();
        var producto_id     = $(this).parents('.fila_regla').attr('data_producto');
        var cliente_id      = $(this).parents('.fila_regla').attr('data_cliente');
        var nombre          = 'CUPON';
        var nombreselect    = 'cupon';
        var tipo            = 'CUP';
        var prefijo         = 'cup';
        var color           = 'danger';

        cerrar_todos_popover(e);

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-modal-detalle",
            data    :   {
                            _token          : _token,
                            producto_id     : producto_id,
                            cliente_id      : cliente_id,
                            nombre          : nombre,
                            nombreselect    : nombreselect,
                            tipo            : tipo,
                            prefijo         : prefijo,
                            color           : color,
                        },
            success: function (data) {
                $('.modal-cupon-container').html(data);
                $('#modal-cupon').niftyModal();
            },
            error: function (data) {
                error500(data);
            }
        });

    });