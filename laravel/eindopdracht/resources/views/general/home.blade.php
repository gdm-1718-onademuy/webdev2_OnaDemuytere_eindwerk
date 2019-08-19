@extends("layout")

@section("content")

<h1>{{$page->name}}</h1>
<div class="intro">{!!$page->content!!}</div> <!-- nu interpreteer je de html tags ipv letterlijk over te nemen -->
<hr>
<p class="spotlight">Products in the spotlight</p>

@foreach($spotlight as $spotlight)
<div style="width: 430px"class="card">
<a href="{{route('ProductsDetailPage', $spotlight->product_id)}}">

    <img style="width:400px;" src="{{asset($spotlight->filepath .'/'. $spotlight->filename)}}">
    </a>
</div>
@endforeach

 
@endsection