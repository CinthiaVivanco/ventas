<div class="panel panel-contrast">
<div class="panel-heading panel-heading-contrast">
      <strong class='c_nombre_cliente'>{{$data_ncl}}</strong>
      <span class="panel-subtitle c_documento-cuenta">{{$data_dcl}}</span>
      <span class="panel-subtitle c_documento-cuenta">{{$data_ccl}}</span>                           
      <span class="mdi mdi-close-circle mdi-close-cliente"></span>
      <span class="mdi mdi-check-circle mdi-check-cliente"
          data_icl='{{$data_icl}}'
          data_pcl='{{$data_pcl}}'
          data_icu='{{$data_icu}}'
          data_pcu='{{$data_pcu}}'
          data_ncl='{{$data_ncl}}'
          data_dcl='{{$data_dcl}}'
          data_ccl='{{$data_ccl}}'
      ></span>
</div>
</div>
<div class="panel-body">
  

    <div class="col-xs-12 margen-top-filtro">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft" >Dirección de entrega:</label>
          <div class="col-sm-12 abajocaja" >

            {!! Form::select( 'direccion_select', $combodirecciones, array(),
                              [
                                'class'       => 'form-control control select2' ,
                                'id'          => 'direccion_select',
                                'data-aw'     => '1',
                              ]) !!}
          </div>
        </div>
    </div>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#direccion_select').select2({
            // Activamos la opcion "Tags" del plugin
            placeholder: 'Seleccione una dirección',
            language: "es",
            tags: true,
            tokenSeparators: [','],
        });
  });
</script> 