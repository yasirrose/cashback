<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Cash Back</title>
  <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/loader.css')) }}" />
  <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
</head>

<body>
  <noscript>
    <strong></strong>
  </noscript>
  <div id="loading-bg">
    <div class="loading-logo">
      
    </div>
    <div class="loading">
      <div class="effect-1 effects"></div>
      <div class="effect-2 effects"></div>
      <div class="effect-3 effects"></div>
    </div>
  </div>
  <div id="app"></div>
  <script src="{{ asset(mix('js/app.js')) }}"></script>
</body>
</html>
