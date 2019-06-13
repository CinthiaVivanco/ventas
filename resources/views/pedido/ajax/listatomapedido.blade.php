<table id="tablatomapedido" class="table table-striped table-hover table-fw-widget dt-responsive nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr> 

      <th>
        <div class="text-center be-checkbox be-checkbox-sm">
          <input  type="checkbox"
                  class="todo"
                  id="todo"
          >
          <label  for="todo"
                  data-atr = "todas"
                  class = "checkbox"                    
                  name="todo"
            ></label>
        </div>
      </th>

      <th>Codigo</th>
      <th>Fecha Venta</th>
      <th>Cliente</th>
      <th>Documento</th>
      <th>Estado</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
   @foreach($listapedidos as $item)
      <tr>

        <td>  

          <div class="text-center be-checkbox be-checkbox-sm">
            <input  type="checkbox"
                    class="{{Hashids::encode(substr($item->id, -8))}}" 
                    id="{{Hashids::encode(substr($item->id, -8))}}" 
                    @if($item->estado != 'EM') disabled @endif>

            <label  for="{{Hashids::encode(substr($item->id, -8))}}"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="{{Hashids::encode(substr($item->id, -8))}}"
            ></label>
          </div>
        </td>

        <td>{{$item->codigo}}</td>
        <td>{{date_format(date_create($item->fecha_time_venta), 'd-m-Y H:i')}}</td>
        <td>{{$item->empresa->NOM_EMPR}}</td>
        <td>{{$item->empresa->NRO_DOCUMENTO}}</td>
        <td>
            @if($item->estado == 'EM') 
              <span class="badge badge-default">emitido</span> 
            @else
              @if($item->estado == 'AC') 
                <span class="badge badge-success">aceptado</span> 
              @else 
                <span class="badge badge-danger">rechazado</span>
              @endif
            @endif
        </td>
        <td>{{$item->total}}</td>

      </tr>                    
    @endforeach


  </tbody>
</table>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif

