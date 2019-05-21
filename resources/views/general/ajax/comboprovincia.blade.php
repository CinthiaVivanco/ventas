<label class="col-sm-12 control-label labelleft">Provincia<span class="required">*</span></label>
<div class="col-sm-7 abajocaja">
  {!! Form::select( 'provincia_id', $comboprovincia, array(),
                    [
                      'class'       => 'form-control control input-sm' ,
                      'id'          => 'provincia_id',
                      'required'    => '',
                      'data-aw'     => '11'
                    ]) !!}
</div>