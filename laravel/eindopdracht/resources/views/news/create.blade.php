@extends("layout")

@section("content")

<h1>Write a new article</h1>   

      <form action="{{route('SaveNews')}}" method="post" class="form-group">
     @csrf
        <div class="card detail">
          <input placeholder="Title" name="title" type="text" class="form-control col-sm-12" value="{{ old('title') }}">
          <br>
          <label>Content</label>
          <textarea name="content" type="text" class="form-control col-sm-12" ></textarea>
        <br>
        
        <br>
          <input value="Submit" class="btn btn-outline-primary mb-2 col-sm-12" type="submit">
      </form>
      <br>
        <br>
        @foreach($errors->all() as $error)
      <div class="alert alert-danger">
        <ul>
            <li>{{ $error }}</li>
        </ul>
      </div>
</div>
      @endforeach

@endsection 