@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
@stop
@section('section')


	<div class="be-content listapedidoosiris">
		<div class="main-content container-fluid main-content-mobile">
          <div class="row">
            <div class="col-sm-12 col-mobil">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista toma de pedidos
                  <div class="tools">

                    <a href="#" class="tooltipcss opciones" id='buscarpedido' data-toggle="tooltip" data-placement="top" title="Buscar Pedido">
                      <span class="icon mdi mdi-search"></span>
                    </a>

                    <form method="POST" id='formpedido' class='opciones' action="{{ url('/enviar-a-osiris/'.$idopcion) }}" style="display: inline-block;" 
                    data-toggle="tooltip" data-placement="top" title="Aceptar pedidos">
                      {{ csrf_field() }}
                      <input type="hidden" id='pedido' name='pedido' >
                      <input type="hidden" id='fechainicio' name='fechainicio' >
                      <input type="hidden" id='fechafin' name='fechafin' >

                      <a href="#" class="tooltipcss" id='enviarpedido' >
                        <span class="tooltiptext">Enviar Pedido</span>
                        <span class="icon mdi mdi-mail-send"></span>
                      </a>
                    </form>

                    <form method="POST" id='formpedidorechazar' class='opciones' action="{{ url('/enviar-a-osiris-rechazar/'.$idopcion) }}" style="display: inline-block;" 
                    data-toggle="tooltip" data-placement="top" title="Rechazar pedidos">
                      {{ csrf_field() }}
                      <input type="hidden" id='pedidorechazar' name='pedidorechazar' >
                      <input type="hidden" id='fechainiciorechazar' name='fechainiciorechazar' >
                      <input type="hidden" id='fechafinrechazar' name='fechafinrechazar' >

                      <a href="#" class="tooltipcss" id='enviarpedidorechazar' >
                        <span class="tooltiptext">Rechazar Pedido</span>
                        <span class="icon mdi mdi-close-circle-o"></span>
                      </a>
                    </form>



                  </div>
                </div>
                <div class="panel-body">


                  <div class='filtrotabla row'>
                    <div class="col-xs-12">
                      <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                          <div class="form-group">
                            <label class="col-sm-12 control-label">
                              Fecha Inicio
                            </label>
                            <div class="col-sm-12">
                              <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker">
                                        <input size="16" type="text" value="{{$fechainicio}}" id='finicio' name='finicio' class="form-control input-sm">
                                        <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                              </div>
                            </div>
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                          <div class="form-group">
                            <label class="col-sm-12 control-label">
                              Fecha Fin
                            </label>
                            <div class="col-sm-12">
                              <div data-min-view="2" data-date-format="dd-mm-yyyy"  class="input-group date datetimepicker">
                                        <input size="16" type="text" value="{{$fechafin}}" id='ffin' name='ffin' class="form-control input-sm">
                                        <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>

                  </div>


                  <div class='listatablapedido listajax'>

                    @include('pedido.ajax.listatomapedido')

                  </div>

                </div>
              </div>
            </div>
          </div>
		</div>

    @include('pedido.modal.detallepedido')

	</div>

@stop

@section('script')


	<script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datatables/js/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>


  <script type="text/javascript">


    $.fn.niftyModal('setDefaults',{
      overlaySelector: '.modal-overlay',
      closeSelector: '.modal-close',
      classAddAfterOpen: 'modal-show',
    });

    $(document).ready(function(){
      //initialize the javascript
      App.init();
      App.dataTables();
      $('[data-toggle="tooltip"]').tooltip(); 
    });
  </script>

  <script src="{{ asset('public/js/pedido/pedido.js?v='.$version) }}" type="text/javascript"></script>

@stop