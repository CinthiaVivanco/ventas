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