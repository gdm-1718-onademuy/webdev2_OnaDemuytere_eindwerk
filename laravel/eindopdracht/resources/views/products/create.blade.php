@extends("layout")

@section("content")

<h1>Create new product</h1>
      <form action="{{route('ProductsSave')}}" method="post" class="form-group">
     @csrf
        <div class="medium-4  columns">
        
          <br>
          <div class= "card detail">
          <input name="title" type="text" class="form-control col-sm-12" placeholder="Title" value="{{ old('title') }}">
          <br>
          <textarea name="content" type="text" class="form-control col-sm-12" placeholder="Description"></textarea>
          <br>
          <label>Category</label>
          <select name="category" class="form-control col-sm-12">
          @foreach($categoryAll as $category)
             <option value='{{$category->id}}'>{{$category->name}}</option>
          @endforeach
          </select>
          <br>

          <!-- meerdere afbeeldingen kunnen uploaden -->

          <input name="targetsum" type="number" class="form-control col-sm-12" placeholder="Target amount">
          <br>

          <input name="deadline" type="date" class="form-control col-sm-12" placeholder="Deadline">
          <br>
        
        <br>
        <div class="medium-12  columns">
          <input value="Create" class="btn btn-outline-primary mb-2 col-sm-12" type="submit">
        </div>
      </form>
</div>
      <br>
        <br>
        @foreach($errors->all() as $error)
      <div class="alert alert-danger">
        <ul>
            <li>{{ $error }}</li>
        </ul>
      </div>
      @endforeach

@endsection