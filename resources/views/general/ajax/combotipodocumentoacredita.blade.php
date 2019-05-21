<label class="col-sm-12 control-label labelleft">Tipo Doc Acredita</label>
<div class="col-sm-8 abajocaja">
  {!! Form::select( 'tipodocumentoacredita_id', $combotipodocumentoacredita, array(),
                    [
                      'class'       => 'form-control control input-sm' ,
                      'id'          => 'tipodocumentoacredita_id',
                      'required'    => '',
                      'data-aw'     => '11'
                    ]) !!}
</div>