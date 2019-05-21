<label class="col-sm-12 control-label labelleft">Tipo Institucion</label>
<div class="col-sm-5 abajocaja">
  {!! Form::select( 'tipoinstitucion_id', $combotipoinstitucion, array(),
                    [
                      'class'       => 'form-control control input-sm' ,
                      'id'          => 'tipoinstitucion_id',
                      'required'    => '',
                      'data-aw'     => '11'
                    ]) !!}
</div>