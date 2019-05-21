<div class="input-group">
  {!! Form::select( 'trabajador_id', $combotrabajadores, array(),
                    [
                      'class'       => 'form-control control input-sm' ,
                      'id'          => 'trabajador_id',
                      'required'    => '',
                      'data-aw'     => '1',
                    ]) !!}
  <span class="input-group-btn ">
    <button  id='agregartrabajadorhorario'
            class="btn btn-success" 
            type="submit" style = 'height:36.5px;'
            data-toggle="tooltip"
            data_semana = '{{Hashids::encode(substr($semana_id, -12))}}'
            data-placement="top" title="Agregar trabajador al horario">
        <i class="fa fa-caret-right"></i>
    </button>
  </span>
</div>