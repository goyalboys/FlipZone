<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/rps.jpg">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/searchscript.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   
    <title>@yield('mytitle') </title>
   
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="{{url('/')}}">FlipZone</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{url('/')}}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('products')}}">Products</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{url('about_us')}}">About Us</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{url('cart')}}">Cart</a>
          </li>
          <li class="nav-item">
            @php
            if (session('type_user')=='merchant')
              echo '<li class="nav-item"><a class="nav-link" href="'.url('dashboard').'">Dashboard</a></li>';
            else
              echo '<li class="nav-item"><a class="nav-link" href="'.url('contact_us').'">Contact Us</a></li>';
            if (session('active_user'))
              { 
                echo '<a class="nav-link" href="'.url('order_history').'">Orders</a>';
                echo '<a class="nav-link" href="'.url('logout').'">Logout</a>';
                
                echo '<li class="nav-item" > 
                        <div class="dropdown">
                          <a   class="nav-link" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" >
                            Profile
                          </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item"  href="edit_profile">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="change_password">Change Password</a></li></ul></div></li>';
              }
            else
              echo '<a class="nav-link" href="'.url('login').'">Login</a>';
            @endphp
              <!--<a class="nav-link" href="login">Login</a>-->
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" onkeyup="showResult(this.value)" >
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
<ul id="myUL">
  <div id="livesearch" style="color:black;"></div>
</ul>
@yield('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>