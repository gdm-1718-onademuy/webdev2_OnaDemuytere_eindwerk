
@extends("layout")
@section("content")
<h1>News</h1>
<a class="create" href="{{url('news/create')}}">Write an article</a>


@foreach($newsAll as $news)
<div class="card">
    <h3>{{$news->title}}</h3>
    @if($news->images->first()['filepath'] !== null)
    <img style="width:100%;" src="{{{ $news->images->first()['filepath'] . '/' . $news->images->first()['filename']}}}">
    @elseif($news->images->first()['filepath'] === null && $news->user_id == Auth::user()->id)
    <p>Voeg een foto toe</p>
    @endif
    <!--img src="">-->
    <div class="container">
    <a href="{{route('NewsDetailPage', $news->id)}}">Read article</a> <br>
    @if(Auth::user())
        @if(Auth::user()->name != null && Auth::user()->name == $news->profile || Auth::user()->type == "admin")
        <a href="{{route('EditNews', $news->id)}}">Edit article</a> <br>
        <a href="{{route('DeleteNews', $news->id)}}">Delete article</a>
        @endif
    @endif
</div></div>
@endforeach
{{$newsAll->links()}}
@endsection

