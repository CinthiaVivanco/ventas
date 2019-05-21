<label class="col-sm-12 control-label labelleft" >Trabajador :</label>
<div class="col-sm-12 abajocaja" >

  {!! Form::select( 'trabajador_id', $combotrabajador, array(),
                    [
                      'class'       => 'select2 form-control control input-sm' ,
                      'id'          => 'trabajador_id',
                      'required'    => '',
                      'data-aw'     => '1',
                    ]) !!}

</div>

<script type="text/javascript">
  $(document).ready(function(){
    //initialize the javascript
    App.init();
    App.formElements();
  });
</script> 