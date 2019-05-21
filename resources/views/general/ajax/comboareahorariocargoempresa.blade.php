<div class="form-group">
  <label class="col-sm-12 control-label labelleft" >Area :</label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'area_id', $comboarea, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'area_id',
                        'required'    => '',
                        'data-aw'     => '2',
                      ]) !!}
  </div>
</div>                


<div class="form-group">
        <label class="col-sm-12 control-label labelleft">Horario: <span class="required">*</span></label>
        <div class="col-sm-7 abajocaja">
          {!! Form::select( 'horario_id', $combohorario, array(),
                            [
                              'class'       => 'form-control control input-sm' ,
                              'id'          => 'horario_id',
                              'required'    => '',
                              'data-aw'     => '26'
                            ]) !!}
        </div>
</div>


 <div class="form-group">
    <label class="col-sm-12 control-label labelleft">Cargo: <span class="required">*</span></label>
    <div class="col-sm-7 abajocaja">
      {!! Form::select( 'cargo_id', $combocargo, array(),
                        [
                          'class'       => 'form-control control input-sm' ,
                          'id'          => 'cargo_id',
                          'required'    => '',
                          'data-aw'     => '26'
                        ]) !!}
    </div>
</div> 


