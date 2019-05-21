<div class="form-group ">

  <label class="col-sm-12 control-label labelleft" >Horario :</label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'horario_id', $combohorario, array(),
                      [
                        'class'       => 'select2 form-control control input-sm' ,
                        'id'          => 'horario_id',
                        'required'    => '',
                        'data-aw'     => '2',
                      ]) !!}
  </div>
</div>

