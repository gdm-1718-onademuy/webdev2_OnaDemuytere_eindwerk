@extends("layout")

@section("content")
<h1>Edit Article</h1>
      <form action="{{route('UpdateNews', $selectedNews->id)}}" method="post" class="form-group">
     @csrf
     @method('PATCH')
     <div class="card detail">

        <div class="medium-4  columns">
        
          <br>
          <label>Titel</label>
        
          <input name="title" type="text" class="form-control col-sm-12" value="{{ $selectedNews->title }}">
          </div>
          <br>
          <label>Content</label>
          <textarea name="content" type="text" class="form-control col-sm-12" >{{ $selectedNews->content }}</textarea>
        <br>
        
        <br>
        <div class="medium-12  columns">
          <input value="Edit" class="btn btn-outline-primary mb-2 col-sm-12" type="submit">
        </div>
      </form>
      <br>
        <br>
        @foreach($errors->all() as $error)
      <div class="alert alert-danger">
        <ul>
            <li>{{ $error }}</li>
        </ul>
      </div></div>
      @endforeach

@endsection