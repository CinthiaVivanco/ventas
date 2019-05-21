  <label class="col-sm-12 control-label labelleft">Cargo <span class="required">*</span></label>
  <div class="col-sm-7 abajocaja">
    {!! Form::select( 'cargo_id', $combocargo, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'cargo_id',
                        'required'    => '',
                        'data-aw'     => '12'
                      ]) !!}
  </div>