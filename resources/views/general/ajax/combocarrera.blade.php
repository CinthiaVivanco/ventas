  <label class="col-sm-12 control-label labelleft">Carrera</label>
  <div class="col-sm-5 abajocaja">
    {!! Form::select( 'carrera_id', $combocarrera, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'carrera_id',
                        'required'    => '',
                        'data-aw'     => '12'
                      ]) !!}
  </div>