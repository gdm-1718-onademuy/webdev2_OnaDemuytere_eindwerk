@extends("layout")

@section("content")

<h1>Products</h1>
<a class="create" href="{{url('products/create')}}">Create a product</a>

@foreach($productsAll as $product)
<div class="card">
    <h3>{{$product->title}}</h3>
    @if($product->images->first()['filepath'] !== null)
    <img style="width:100%;" src="{{{ $product->images->first()['filepath'] . '/' . $product->images->first()['filename']}}}">
    @endif
    <a href="{{route('ProductsDetailPage', $product->id)}}">Detail page</a>
    @if(Auth::user())
        @if(Auth::user()->id == $product->user_id || Auth::user()->type == "admin")
        <a href="{{route('ProductsEdit', $product->id)}}">Edit page</a>
        <a href="{{route('ProductsDelete', $product->id)}}">Delete page</a>
        @endif
    @endif
 
</div>
@endforeach
 
@endsection


