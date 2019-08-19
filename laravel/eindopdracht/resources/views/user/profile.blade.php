@extends("layout")

@section("content")


<div>
    <div class="profile">
    <h1>My Profile</h1>

    @if($user->images->first()['filepath'] === null)
    <form action="{{ route('ProfileImageStore', $user->id) }}" method="post" enctype="multipart/form-data" class="form-group"> 
            @csrf
            <div class="field">
                <div class="control">
                    <input class="form-control" type="text" name="user_id"
                        value="{{$user->id}}" hidden>
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
            <button type="submit" class="form-control btn btn-outline-primary">
                Submit
            </button><br>
        </form>
        @else
        <img style="width:200px; height:200px; margin: 30px; margin-left: 80px; border-radius:50%; object-fit:cover;" src="{{asset($user->images->first()['filepath'].'/'.$user->images->first()['filename'])}}">

        @endif
    <p>{{$user->name}}</p>
    <p>{{$user->credits}} <span class="badge badge-warning">Credits</span></p>
    <a href="{{url('/credits')}}">Buy credits</a>
    </div>
    <div class="myItems">
    <h1>My articles and products</h1>
<hr>
    @foreach($articles as $article) 
        <div>
            <div class="profileItems">
                <h2>{{$article->title}}</h2>                
                <a href="{{route('NewsDetailPage', $article->id)}}">Read article</a> <br>
                <a href="{{route('EditNews', $article->id)}}">Edit article</a> <br>
                <a href="{{route('DeleteNews', $article->id)}}">Delete article</a>
            </div>
        </div>
    <hr>
    @endforeach
    @foreach($products as $product) 
        <div>
            <div class="profileItems">
                <h2>{{$product->title}}</h2>
                <a href="{{route('ProductsDetailPage', $product->id)}}">Read product</a> <br>
                <a href="{{route('ProductsEdit', $product->id)}}">Edit product</a> <br>
                <a href="{{route('ProductsDelete', $product->id)}}">Delete product</a>
            </div>
        </div>
        <hr>
    @endforeach
</div>
</div>

@endsection