<label class="col-sm-12 control-label labelleft">Área <span class="required">*</span></label>
<div class="col-sm-7 abajocaja">
  {!! Form::select( 'area_id', $comboarea, array(),
                    [
                      'class'       => 'form-control control input-sm' ,
                      'id'          => 'area_id',
                      'required'    => '',
                      'data-aw'     => '18'
                    ]) !!}


</div>