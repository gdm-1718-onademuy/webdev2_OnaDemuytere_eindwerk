@extends("layout")

@section("content")

<h1>Edit product</h1>
<form action="{{route('ProductsUpdate', $selectedProduct->id)}}" method="post" class="form-group">
     @csrf
     @method('PATCH')
     <div class="card detail">

        <div class="medium-4  columns">
        
          <br>
          <label>Title</label>
        
          <input name="title" type="text" class="form-control col-sm-12" value="{{ $selectedProduct->title }}">
          </div>
          <br>
          <label>Description</label>
          <textarea name="content" type="text" class="form-control col-sm-12" >{{ $selectedProduct->content }}</textarea>

          <label>Category</label>
          <select name="category" class="form-control col-sm-12" value="{{ $selectedProduct->category }}">
          @foreach($categoryAll as $category)
             <option @if( $selectedProduct->category_id == $category->id) selected @endif value='{{$category->id}}'>
             {{ ucfirst($category->name) }}
             </option>
          @endforeach
          </select>
        <br>
        <label>Target amount</label>
        <input name="targetsum" type="number" class="form-control col-sm-12" value="{{ $selectedProduct->targetsum }}">
          <br>
          <label>Deadline</label>
          <input name="deadline" type="date" class="form-control col-sm-12" value="{{ $selectedProduct->deadline }}"">
          
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