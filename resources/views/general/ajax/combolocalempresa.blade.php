<label class="col-sm-12 control-label labelleft">Local:<span class="required">*</span></label>
<div class="col-sm-7 abajocaja">

   {!! Form::select( 'local_id', $combolocal, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'local_id',
                        'required'    => '',
                        'data-aw'     => '12'
                      ]) !!}
</div>