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
  <title>Holipic Admin</title>
</head>

<body>
  <div id="app"></div>
  <script type="text/javascript">
    localStorage.setItem('accesss_token', '{{ isset($token) ? $token : "" }}');
    localStorage.setItem('currentUser', '{{ isset($currentUser) ? json_encode($currentUser) : "" }}');
  </script>
  <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>

</html>