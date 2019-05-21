
  <label class="col-sm-12 control-label labelleft" >Area :</label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'area_id', $comboarea, array(),
                      [
                        'class'       => 'select2 form-control control input-sm' ,
                        'id'          => 'area_id',
                        'required'    => '',
                        'data-aw'     => '2',
                      ]) !!}
  </div>


<script type="text/javascript">
  $(document).ready(function(){
    //initialize the javascript
    App.init();
    App.formElements();
  });
</script> 