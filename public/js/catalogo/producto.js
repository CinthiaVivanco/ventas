
$(document).ready(function(){

	var carpeta = $("#carpeta").val();

    $(".precioproducto").on('keypress','.updateprice', function(e) {

    	var check 			= '<i class="mdi mdi-check-circle"></i>';
        var _token      	= $('#token').val();
        var puntero         = $(this);
        var precio 			= $(this).val();
        var producto_id 	= $(this).parents('tr').attr('data-id');
        var producto_pre 	= $(this).parents('tr').attr('data-pref');

        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){

	        $.ajax({
	            
	            type    :   "POST",
	            url     :   carpeta+"/ajax-guardar-precio-producto",
	            data    :   {
	                            _token  		: _token,
	                            precio 			: precio,
	                            producto_id 	: producto_id,
	                            producto_pre 	: producto_pre
	                        },
	            success: function (data) {
	                alertajax(data);
	                puntero.val("");
	                puntero.parent('.columna-warning').siblings('.columna-precio').html(check+' '+precio);
                    puntero.parent('.columna-warning').siblings('.columna-precio').removeClass("columna-default");	
                    puntero.parent('.columna-warning').siblings('.columna-precio').addClass("columna-success");
	            },
	            error: function (data) {
	                if(data.status = 500){
	                    var contenido = $(data.responseText);
	                    alerterror505ajax($(contenido).find('.trace-message').html()); 
	                    console.log($(contenido).find('.trace-message').html());     
	                }
	            }
	        });



        }
    });

    $(".crearcupon").on('click','.generarcupon', function(e) {

        var _token      	= $('#token').val();

        $.ajax({
            
            type    :   "POST",
            url     :   carpeta+"/ajax-generarcupon",
            data    :   {
                            _token  		: _token
                        },
            success: function (data) {
                $('#cupon').val(data);                   
            },
            error: function (data) {
                if(data.status = 500){
                    var contenido = $(data.responseText);
                    alerterror505ajax($(contenido).find('.trace-message').html()); 
                    console.log($(contenido).find('.trace-message').html());     
                }
            }
        });

    });


    $(".crearcupon").on('click','.tipodescuento', function(e) {

        var value = $(this).val();
        if(value == 'POR'){
            $(".ssoles").css("display", "none");
            $(".sporcentaje").css("display", "table-cell");
        }else{
            $(".ssoles").css("display", "table-cell");
            $(".sporcentaje").css("display", "none");
        }
    });


});