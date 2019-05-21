  <label class="col-sm-12 control-label labelleft">Distrito<span class="required">*</span></label>
  <div class="col-sm-7 abajocaja">
    {!! Form::select( 'distrito_id', $combodistrito, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'distrito_id',
                        'required'    => '',
                        'data-aw'     => '12'
                      ]) !!}
  </div>