@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
@stop
@section('section')


	<div class="be-content">
		<div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista de Cupones
                  <div class="tools">
                    <a href="{{ url('/agregar-regla-cupon/'.$idopcion) }}" data-toggle="tooltip" data-placement="top" title="Crear Cupon">
                      <span class="icon mdi mdi-plus-circle-o"></span>
                    </a>


                  </div>
                </div>
                <div class="panel-body">
                  <table id="tablecupones" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Cupon</th>
                        <th>Cantidad</th>
                        <th>Fecha de expiración</th>
                        <th>Estado</th>
                        <th>Opción</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($listacupones as $item)
                        <tr>
                          <td>{{$item->nombre}}</td>
                          <td>{{$item->cupon}}</td>
                          <td>
                            @if($item->cantidadminima == 0) 
                              <span class="badge badge-default">ilimitado</span> 
                            @else 
                              <span class="badge badge-default">{{$item->cantidadminima}}</span>
                            @endif
                          </td>
                          <td>
                            @if($item->fechafin == $fechavacia) 
                              <span class="badge badge-default">ilimitado</span> 
                            @else 
                              {{date_format(date_create($item->fechafin), 'd-m-Y H:i')}}
                            @endif
                          </td>
                          <td> 
                            @if($item->estado == 'PU') 
                              <span class="badge badge-success">PUBLICADO</span>
                            @else 
                              @if($item->estado == 'NP') 
                                <span class="badge badge-warning">NO PUBLICADO</span>
                              @else
                                <span class="badge badge-danger">CERRADO</span> 
                              @endif
                            @endif

                          </td>
                          <td class="rigth">
                            <div class="btn-group btn-hspace">
                              <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                              <ul role="menu" class="dropdown-menu pull-right">
                                <li>
                                  <a href="{{ url('/modificar-regla-cupon/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}">
                                    Modificar
                                  </a>  
                                </li>
                              </ul>
                            </div>
                          </td>
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