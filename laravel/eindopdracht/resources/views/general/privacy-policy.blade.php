@extends("layout")

@section("content")

<h1>{{$page->name}}</h1>
<div class="about">{!!$page->content!!}</div> <!-- nu interpreteer je de html tags ipv letterlijk over te nemen -->
 
@endsection