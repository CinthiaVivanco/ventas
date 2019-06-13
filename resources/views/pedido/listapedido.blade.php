@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
@stop
@section('section')


	<div class="be-content">
		<div class="main-content container-fluid main-content-mobile">
          <div class="row">
            <div class="col-sm-12 col-mobil">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista de pedidos
                  <div class="tools">
                    <a href="{{ url('/agregar-orden-pedido/'.$idopcion) }}" data-toggle="tooltip" data-placement="top" title="Crear Orden">
                      <span class="icon mdi mdi-plus-circle-o"></span>
                    </a>
                  </div>
                </div>
                <div class="panel-body">
                  <table id="tablepedido" class="table table-striped table-hover table-fw-widget dt-responsive nowrap" style='width: 100%;'>
                    <thead>
                      <tr> 
                        <th>Codigo</th>
                        <th>Fecha Venta</th>
                        <th>Cliente</th>
                        <th>Documento</th>
                        <th>Igv</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach($listapedidos as $item)
                        <tr>
                          <td>{{$item->codigo}}</td>
                          <td>{{date_format(date_create($item->fecha_time_venta), 'd-m-Y H:i')}}</td>
                          <td>{{$item->empresa->NOM_EMPR}}</td>
                          <td>{{$item->empresa->NRO_DOCUMENTO}}</td>
                          <td>{{$item->igv}}</td>
                          <td>{{$item->subtotal}}</td>
                          <td>{{$item->total}}</td>
  
                        </tr>                    
                      @endforeach


                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
		</div>
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




    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script> 
@stop