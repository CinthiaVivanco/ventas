
$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    $(".crearpedido").on('click','.filapedido', function(e) {

        var data_icl        =   $(this).attr('data_icl');
        var data_pcl        =   $(this).attr('data_pcl');
        var data_icu        =   $(this).attr('data_icu');
        var data_pcu        =   $(this).attr('data_pcu');
        var data_ncl        =   $(this).attr('data_ncl');
        var data_dcl        =   $(this).attr('data_dcl');
        var data_ccl        =   $(this).attr('data_ccl');


        activaTab('productotp');
        agregar_cliente(data_ncl,data_dcl,data_ccl)
        alertmobil("Cliente "+data_ncl+" seleccionado");

    });


    $(".crearpedido").on('click','.filaproducto', function(e) {

        var data_ipr        =   $(this).attr('data_ipr');
        var data_ppr        =   $(this).attr('data_ppr');
        var data_npr        =   $(this).attr('data_npr');
        var data_upr        =   $(this).attr('data_upr');
        $('.listaproductos').toggle("slow");
        $('.precioproducto').toggle("slow");
        tituloprecioproducto(data_npr,data_upr,data_ipr,data_ppr);

    });

    $(".crearpedido").on('click','.mdi-close-precio', function(e) {

        $('.listaproductos').toggle("slow");
        $('.precioproducto').toggle("slow");

    });

    // borrando un producto
    $(".crearpedido").on('click','.mdi-close-pedido', function(e) {
        $(this).parents('.productoseleccion').remove();
    });




    $(".crearpedido").on('click','.mdi-check-precio', function(e) {

        var cantidad            =   $('#cantidad').val();
        var precio              =   $('#precio').val();
        var data_ipr            =   $(this).attr('data_ipr');
        var data_ppr            =   $(this).attr('data_ppr');
        var data_npr            =   $(this).attr('data_npr');
        var data_upr            =   $(this).attr('data_upr');

        // validacion cantidad
        if(cantidad =='0.00' || cantidad==''){ alertdangermobil("Ingrese cantidad"); return false;}
        if(precio =='0.00' || precio==''){ alertdangermobil("Ingrese precio"); return false;}
        agregar_producto(data_npr,data_upr,cantidad,precio);
        alertmobil("Producto "+data_npr+" agregado");
        limpiar_input_producto();
        $('.listaproductos').toggle("slow");
        $('.precioproducto').toggle("slow");
        return true;

    });
});




function activaTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
}

function tituloprecioproducto(data_npr,data_upr,data_ipr,data_ppr){

    // limpiar
    $('.p_nombre_producto').html('');
    $('.p_unidad_medida').html('');

    $(".mdi-check-precio").attr("data_ipr",'');
    $(".mdi-check-precio").attr("data_ppr",'');
    $(".mdi-check-precio").attr("data_npr",'');
    $(".mdi-check-precio").attr("data_upr",'');

    // AGREGAR 

    $('.p_nombre_producto').html(data_npr);
    $('.p_unidad_medida').html(data_upr);

    // agregar todos los valores del producto al check 
    $(".mdi-check-precio").attr("data_ipr",data_ipr);
    $(".mdi-check-precio").attr("data_ppr",data_ppr);
    $(".mdi-check-precio").attr("data_npr",data_npr);
    $(".mdi-check-precio").attr("data_upr",data_upr);
  

}

function limpiar_input_producto(){
    $('#cantidad').val('');
    $('#precio').val('');
}


function agregar_cliente(nombrecliente,ruc,cuenta){

    var cadena = '';            
    cadena += " <div class='col-sm-12'>";
    cadena += "     <div class='panel panel-full'>";
    cadena += "         <div class='panel-heading cell-detail'>";
    cadena +=               nombrecliente;
    cadena += "             <span class='panel-subtitle cell-detail-description-producto'>"+ruc+"</span>";
    cadena += "             <span class='panel-subtitle cell-detail-description-contrato'>"+cuenta+"</span>";
    cadena += "         </div>";
    cadena += "     </div>";
    cadena += " </div>";

    $(".detallecliente").html(cadena);


}

function agregar_producto(nombreproducto,unidadmedida,cantidad,precio){

    var cadena = '';            
    cadena += " <div class='col-sm-12 productoseleccion'>";
    cadena += "     <div class='panel panel-default panel-contrast'>";
    cadena += "         <div class='panel-heading cell-detail'>";
    cadena +=               nombreproducto;
    cadena += "             <div class='tools'>";
    cadena += "                 <span class='icon mdi mdi-close mdi-close-pedido'></span>";
    cadena += "             </div>";
    cadena += "             <span class='panel-subtitle cell-detail-description-producto'>"+cantidad+" "+unidadmedida+"</span>";
    cadena += "             <span class='panel-subtitle cell-detail-description-contrato'>S/."+precio+"</span>";
    cadena += "         </div>";
    cadena += "     </div>";
    cadena += " </div>";
    $(".detalleproducto").append(cadena);

}