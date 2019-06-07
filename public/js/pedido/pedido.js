
$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    //guardar pedido


    $(".crearpedido").on('click','.btn-guardar', function(e) {

        var cliente             =   $('#cliente').val();
        // validacion cliente
        if(cliente==''){ alertdangermobil("Seleccione un cliente"); return false;}
        // validacion productos
        data = agregar_producto_hidden();
        if(data.length<=0){alertdangermobil("Seleccione por lo menos un producto"); return false;}
        var datastring = JSON.stringify(data);
        $('#productos').val(datastring);
        return true;
    });


    $(".crearpedido").on('click','.filapedido', function(e) {

        var data_icl        =   $(this).attr('data_icl');
        var data_pcl        =   $(this).attr('data_pcl');
        var data_icu        =   $(this).attr('data_icu');
        var data_pcu        =   $(this).attr('data_pcu');
        var data_ncl        =   $(this).attr('data_ncl');
        var data_dcl        =   $(this).attr('data_dcl');
        var data_ccl        =   $(this).attr('data_ccl');

        activaTab('productotp');
        agregar_cliente(data_ncl,data_dcl,data_ccl);
        agregar_cliente_hidden(data_pcl,data_icl,data_pcu,data_icu);  
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

    // atras en los tabs
    $(".crearpedido #pedidotp").on('click','.col-atras', function(e) {
        activaTab('productotp');
    });
    $(".crearpedido #productotp").on('click','.col-atras', function(e) {
        activaTab('clientetp');
    });

    // borrando un producto
    $(".crearpedido").on('click','.mdi-close-pedido', function(e) {
        $(this).parents('.productoseleccion').remove();
        //agregar_producto_hidden();
        calcular_total();
    });


    // agregando producto
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
        if(existe_producto(data_ppr,data_ipr) == '0'){ alertdangermobil("El producto ya existe en el pedido"); return false;}

        agregar_producto(data_npr,data_upr,cantidad,precio,data_ipr,data_ppr);
        //agregar_producto_hidden();
        calcular_total();
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
function agregar_cliente_hidden(data_pcl,data_icl,data_pcu,data_icu){
    $('#cliente').val(data_pcl+'-'+data_icl);
    $('#cuenta').val(data_pcu+'-'+data_icu);
}


function agregar_producto_hidden(){

    var data = [];
    $(".detalleproducto .productoseleccion").each(function(){

        var data_ppr_for = $(this).attr('data_ppr');
        var data_ipr_for = $(this).attr('data_ipr');
        var data_prpr_for = $(this).attr('data_prpr');
        var data_ctpr_for = $(this).attr('data_ctpr');
        data.push({
            prefijo_producto    : data_ppr_for,
            id_producto         : data_ipr_for,
            precio_producto     : data_prpr_for,
            cantidad_producto   : data_ctpr_for,
        });

    });
    return data;
}

function calcular_total(){
    var total = 0.00;
    $(".detalleproducto .productoseleccion").each(function(){
        var data_ppr_for = $(this).attr('data_prpr');
        var data_ipr_for = $(this).attr('data_ctpr');
        total = total + parseFloat(data_ppr_for)*parseFloat(data_ipr_for);
    });
    $('.total').html(total.toFixed(4));
}


function existe_producto(data_ppr,data_ipr){

    var sw = '1';
    $(".detalleproducto .productoseleccion").each(function(){
        var data_ppr_for = $(this).attr('data_ppr');
        var data_ipr_for = $(this).attr('data_ipr');
        if(data_ppr_for == data_ppr && data_ipr_for == data_ipr){
            sw = '0';
        }
    });
    return sw;

}



function agregar_producto(nombreproducto,unidadmedida,cantidad,precio,data_ipr,data_ppr){

    var importe = parseFloat(cantidad)*parseFloat(precio);
    var cadena = '';  
    cadena += "<div class='col-sm-12 productoseleccion'";
    cadena += "data_ipr='"+data_ipr+"' data_ppr= '"+data_ppr+"' data_prpr='"+precio+"' data_ctpr='"+cantidad+"' >" 
    cadena += "     <div class='panel panel-default panel-contrast'>";
    cadena += "         <div class='panel-heading cell-detail'>";
    cadena +=               nombreproducto;
    cadena += "             <div class='tools'>";
    cadena += "                 <span class='icon mdi mdi-close mdi-close-pedido'></span>";
    cadena += "             </div>";
    cadena += "             <span class='panel-subtitle cell-detail-producto'>Cantidad : "+cantidad+" "+unidadmedida+"</span>";
    cadena += "             <span class='panel-subtitle cell-detail-producto'>Precio : S/."+precio+" <strong> Importe "+importe.toFixed(4)+" </strong></span>";
    cadena += "         </div>";
    cadena += "     </div>";
    cadena += "</div>";
    $(".detalleproducto").append(cadena);

}