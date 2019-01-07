<?php 
  $SOCKET_IO_PORT = env('SOCKET_IO_PORT', 6001);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css?family=Heebo:300,400,500,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="{{asset('css/holipic.css')}}">

  <title>Holipic Admin</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js"></script>

</head>


<body>
  <div id="app"></div>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
  <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
    <script>
      const SOCKET_IO_PORT = '{!! $SOCKET_IO_PORT !!}';
      console.log(SOCKET_IO_PORT);
      
      var socket = io(':' + SOCKET_IO_PORT);

      var global_notification = [];

    </script>


  <script type="text/javascript" src="{{asset('js/app.js')}}"></script>

</body>
  
</html>