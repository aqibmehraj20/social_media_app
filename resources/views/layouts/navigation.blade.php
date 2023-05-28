<!DOCTYPE html>
<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Social Media</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/nav.css') }} ">
  </head>
<body>

<div class="topnav" id="myTopnav">
@if (Route::has('login'))

@auth
  <a href="{{ url('/') }}" class="active">Home <i class="fa fa-home" aria-hidden="true"></i></a>
  <a href="{{ url('/posts') }}">Feed<i class="fa fa-book"></i></a>
  @endauth

  <div class="right-lnk">
  @auth
  <a href="{{ route('profile') }}">{{ Auth::user()->name }}</i></a>
  <a href="{{ route('logout') }}">Logout</i></a>
  @else
  <a href="{{ route('login') }}">Login</i></a>
  @if (Route::has('register'))
  <a href="{{ route('register') }}">Register</i></a>
  @endif
  @endauth

  @endif

</div>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>





</body>
</html>

