<!-- Header -->
<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top" style=" width:100%; z-index:2; margin-bottom:2%;">

<span class="navbar-brand">GOFUND</span>

<div class=" navbar-collapse" id="navbarNavAltMarkup">

    <div class="navbar-nav">
    <a class="nav-item nav-link" href="{{url('/')}}">Home</a>
    <a class="nav-item nav-link" href="{{url('/news')}}">News</a>
    <a class="nav-item nav-link" href="{{url('/products')}}">Products</a>
@if(Auth::user())
    <a class="nav-item nav-link" href="{{url('/profile')}}">Profile</a>
    <a class="nav-item nav-link" href="{{url('/logout')}}">Logout</a>
@else
    <a class="nav-item nav-link" href="{{url('/login')}}">Login</a>
@endif
</div>
  </div>
</nav>
