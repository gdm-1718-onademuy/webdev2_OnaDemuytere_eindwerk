<!-- alles hierin wordt toegepast op elke pagina -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="stripe-token" content="{{env('STRIPE_KEY')}}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stripe-demo.css') }}">
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const creditRatio = {{ env('CREDIT_RATIO') }};
        </script>
    <title>Layout</title>
</head>
<body id="page-content" class="d-flex flex-column">
@include("header-footer/header")
@if (session('fail'))
    <div class="alert alert-danger col-lg-12">
        {{ session('fail') }}
    </div>
    @endif
    @if (session('succes'))
    <div class="alert alert-success col-lg-12">
        {{ session('succes') }}
    </div>
@endif
<div id="container">

<div> @yield("content") </div>
</div>

@include("header-footer/footer")
<script> let convertUrl = "{{route('converter')}}";</script>
<script src="{{ asset('js/stripe-demo.js') }}"></script>


</body>
</html>