@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>

@stop
@section('section')

<div class="be-content crearpedido">
  <div class="main-content container-fluid main-content-mobile">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12 col-mobil">

        <div class="panel panel-default">
          <!--<div class="panel-heading">Orden de pedido</div>-->
          <div class="tab-container">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#clientetp" data-toggle="tab">CLIENTES</a></li>
              <li><a href="#productotp" data-toggle="tab">PRODUCTOS</a></li>
              <li><a href="#pedidotp" data-toggle="tab">PEDIDO</a></li>
            </ul>
            <div class="tab-content">
              <div id="clientetp" class="tab-pane active cont">

                  <table id="tableclientetp" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>CLIENTES</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($listaclientes as $item)
                        <tr class='filapedido'
                            data_icl='{{Hashids::encode(substr($item->id, -10))}}'
                            data_pcl='{{substr($item->id, 0, 6)}}'
                            data_icu='{{Hashids::encode(substr($item->COD_CONTRATO, -10))}}'
                            data_pcu='{{substr($item->COD_CONTRATO, 0, 6)}}'
                            data_ncl='{{$item->NOM_EMPR}}'
                            data_dcl='{{$item->NRO_DOCUMENTO}}'
                            data_ccl='{{$item->CONTRATO}}'
                            >
                          <td class="cell-detail">
                            <span>{{$item->NOM_EMPR}}</span>
                            <span class="cell-detail-description-producto">{{$item->NRO_DOCUMENTO}}</span>
                            <span class="cell-detail-description-contrato">{{$item->CONTRATO}}</span>
                          </td>
                        </tr>                    
                      @endforeach

                    </tbody>
                  </table>
              </div>
              <div id="productotp" class="tab-pane cont">
              
                <div class='listaproductos'>
                  <table id="tableproductotp" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>PRODUCTOS</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($listaproductos as $item)
                        <tr class='filaproducto'
                            data_ipr='{{Hashids::encode(substr($item->COD_PRODUCTO, -13))}}'
                            data_ppr='{{substr($item->COD_PRODUCTO, 0, 3)}}'
                            data_npr='{{$item->NOM_PRODUCTO}}'
                            data_upr='{{$item->NOM_UNIDAD_MEDIDA}}'>
                          <td class="cell-detail">
                            <span>{{$item->NOM_PRODUCTO}}</span>
                            <span class="cell-detail-description-producto">{{$item->NOM_UNIDAD_MEDIDA}}</span>
                          </td>
                        </tr>                    
                      @endforeach

                    </tbody>
                  </table>
                </div>

                <div class="row precioproducto">
                  <div class="col-sm-12">
                    <div class="panel panel-contrast">
                      <div class="panel-heading panel-heading-contrast">
                            <strong class='p_nombre_producto'>Nombre producto</strong>
                            <span class="panel-subtitle p_unidad_medida">unidad medida</span>                          
                            <span class="mdi mdi-close-circle mdi-close-precio"></span>
                            <span class="mdi mdi-check-circle mdi-check-precio"
                              data_ipr=''
                              data_ppr=''
                              data_npr=''
                              data_upr=''
                            ></span>
                      </div>
                    </div>
                    <div class="panel-body">
                    
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label class="col-sm-12 control-label">
                            Cantidad
                          </label>
                          <div class="col-sm-12">
                            <div class="input-group_mobil">
                              <input  type="text"
                                      id="cantidad" name='cantidad' 
                                      value="" 
                                      placeholder="Cantidad"
                                      required = "" class="form-control input-sm importe" data-parsley-type="number"
                                      autocomplete="off" data-aw="1"/>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group">
                          <label class="col-sm-12 control-label">
                            Precio
                          </label>
                          <div class="col-sm-12">
                            <div class="input-group_mobil">
                              <input  type="text"
                                      id="precio" name='precio' 
                                      value="" 
                                      placeholder="Precio"
                                      required = "" class="form-control input-sm importe" data-parsley-type="number"
                                      autocomplete="off" data-aw="2"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    </div>
                  </div>
                </div>

              <div id="pedidotp" class="tab-pane">

                <div class="row detallecliente">
                  <!-- DATOS DEL CLIENTE -->
                </div>

                <div class="row detalleproducto">

                  <!-- DATOS DEL PRODUCTO -->
                  
                  <!--<div class="col-sm-12">
                    <div class="panel panel-default panel-contrast">
                      <div class="panel-heading cell-detail">
                        Nombre Producto
                        <div class="tools">
                          <span class="icon mdi mdi-close"></span>
                        </div>
                        <span class="panel-subtitle cell-detail-description-producto">Unidad medida</span>
                        <span class="panel-subtitle cell-detail-description-contrato">precio</span>
                      </div>
                    </div>
                  </div> -->              
                  
                </div> 


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  



@stop

@section('script')


    <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script> 
    <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

	  <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>


    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        App.formElements();
        $('form').parsley();

        $('.importe').inputmask({ 'alias': 'numeric', 
        'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
        'digitsOptional': false, 
        'prefix': '', 
        'placeholder': '0'});

      });
    </script> 

    <script src="{{ asset('public/js/pedido/pedido.js?v='.$version) }}" type="text/javascript"></script>

@stop