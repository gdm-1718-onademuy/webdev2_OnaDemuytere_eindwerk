@extends("layout")

@section("content")
<div class="card detail">
<h1>{{$products->title}}</h1>
<div class="row">
@foreach($imageAll as $image)
<a href="{{asset($image->filepath .'/'.$image->filename)}} " data-fancybox="gallery" class="col">
    <img class="w-100 m-1" style="height:30vh;" src="{{asset($image->filepath .'/'.$image->filename)}} ">
</a>
@endforeach
</div>
{{$imageAll->links()}}
<h4>By {{$user->name}}</h4>

<p style="text-transform: uppercase;">{{$category->name}}</p>
<hr>
<p>Deadline: {{$products->deadline}}</p>

<div class="progress" style="width: 100%">
    <div class="progress-bar progress-bar-striped progress-bar-animated rounded-0" role="progressbar"
        style="width: {{ $funded / $products->targetsum * 100 }}%" aria-valuenow="10" aria-valuemin="0"
        aria-valuemax="100"></div>
</div>
<p>€{{$funded}} from €{{$products->targetsum}} funded</p>

@if(Auth::user()->id != $user->id)
    <form action="{{route('ProductsFund',$products->id )}}" method="post" class="form-group">
     @csrf
     <div class="medium-12  columns">
     <input name="amount" type="number" class="form-control col-sm-2" placeholder="Amount of coins" value="{{ old('title') }}"><input value="Fund" class="btn btn-outline-primary mb-2 col-sm-2" type="submit">
        </div>    </form>
    @endif
    @if(Auth::user())
     @if(Auth::user()->id != null && Auth::user()->id == $user->id || Auth::user()->type == "admin")
        @foreach($fundList as $funding)
            <div>
                <p>{{$funding->username}} funded {{$funding->amount}} coins at {{$funding->created_at}}</p>

            </div>
        @endforeach
    @endif
    @endif


<hr>
<p>{{$products->content}}</p>
<hr>


<a href="{{route('PDF', $products->id)}}">Download pdf</a>

@if(Auth::user())
    @if(Auth::user()->id != null && Auth::user()->id == $user->id || Auth::user()->type == "admin")
        <a href="{{route('ProductsEdit', $products->id)}}">Edit product</a>
        <a href="{{route('ProductsDelete', $products->id)}}">Delete product</a>
        @if($firstimage != null)
        <a href="{{route('ProductsSpotlight', $products->id)}}">Put in the spotlight</a>
        @else
        <a><p>Add a picture to put in the spotlight</p></a>
        @endif
        <hr>
        <form action="{{ route('ProductImageStore', $products->id) }}" method="post" enctype="multipart/form-data" class="form-group">             
            <p class=" mb-3"> Add pictures to your product</p>
            @csrf
            <div class="field">
                <div class="control">
                    <input class="form-control" type="text" name="product_id"
                        value="{{$products->id}}" hidden>
                </div>
            </div>
            <table class="table is-striped">
                <tbody>
                    <tr>
                        <td>
                            <input type="file" name="file[]" id="file" multiple>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input value="Upload" class="form-control btn btn-outline-primary mb-2 col-sm-2" type="Upload">
        </form>
    @endif
    <hr>
    <form action="{{route('ProductsComment',$products->id )}}" method="post" class="form-group">
     @csrf
     <textarea name="comment" class="form-control col-sm-12" placeholder="Your comment on this product" value="{{ old('title') }}"></textarea>
     <input value="Comment" class="btn btn-outline-primary mb-2 col-sm-2" type="Comment">
    </form>
@endif
<div>
    @foreach($commentAll as $comment)
        @if($comment->product_id == $products->id)
            <div>
                <h4>{{$comment->username}} wrote at {{$comment->created_at}}:</h4>
                <p>{{$comment->comment}}</p>
            </div>  
        @endif 
    @endforeach
</div></div>

@endsection