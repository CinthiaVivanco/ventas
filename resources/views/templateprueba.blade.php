<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">

    <link rel="icon" href="{{ asset('public/img/icono/ico.ico') }}">   
    <title>Induamerica - Sistema de Ventas</title>

    @yield('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/style.min.css?v='.$version) }} "/>


  </head>
  <body>


    <div class="be-wrapper be-fixed-sidebar">
        @yield('section')
         <input type='hidden' id='carpeta' value="{{$capeta}}"/>
         <input type="hidden" id="token" name="_token"  value="{{ csrf_token() }}"> 
    </div>


    <script src="{{ asset('public/lib/jquery/jquery-2.1.3.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
  

    @yield('script')

  </body>
</html>