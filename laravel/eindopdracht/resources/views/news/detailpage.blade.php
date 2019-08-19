
@extends("layout")

@section("content")
<div class="card detail">
<h2>{{$news->title}}</h1>
<h4>By {{$news->profile}}</h4>
<hr>
<!--Tijd nog toevoegen-->
<h5>Posted on {{$news->created_at}}</h5>
<hr>
<p>{{$news->content}}</p>
<hr>
<img style="width:100%;" src="{{asset($news->images->first()['filepath'].'/'.$news->images->first()['filename'])}}">
<hr>
@if(Auth::user())
    @if(Auth::user()->name != null && Auth::user()->name == $news->profile || Auth::user()->type == "admin")
        <a href="{{route('EditNews', $news->id)}}">Edit article</a><br>
        <a href="{{route('DeleteNews', $news->id)}}">Delete article</a>
        @if($news->images->first()['filepath'] === null)
        <form action="{{ route('NewsImageStore', $news->id) }}" method="post" enctype="multipart/form-data" class="form-group"> 
            @csrf
            <div class="field">
                <div class="control">
                    <input class="form-control" type="text" name="news_id"
                        value="{{$news->id}}" hidden>
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
            <button type="submit" class="form-control btn btn-primary">
                Verzenden
            </button><br>
        </form>
        @endif
    @endif
@endif
</div

@endsection
