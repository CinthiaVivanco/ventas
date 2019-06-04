@extends('template')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>

@stop
@section('section')

<div class="be-content">
  <div class="main-content container-fluid main-content-mobile">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12 col-mobil">

        <div class="panel panel-default">
          <div class="panel-heading">Orden de pedido</div>
          <div class="tab-container">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#cliente" data-toggle="tab">CLIENTE</a></li>
              <li><a href="#producto" data-toggle="tab">PRODUCTOS</a></li>
              <li><a href="#pedido" data-toggle="tab">PEDIDO</a></li>
            </ul>
            <div class="tab-content">
              <div id="cliente" class="tab-pane active cont">

              </div>
              <div id="producto" class="tab-pane cont">

              </div>
              <div id="pedido" class="tab-pane">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  



@stop

@section('script')


	  <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });
    </script> 
@stop