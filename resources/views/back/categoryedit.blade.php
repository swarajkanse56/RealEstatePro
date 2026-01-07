@extends('back.master')

@section('title', 'Edit Category')

@section('content')
    <div class="container">
        <h1>Edit Category</h1>

        <!-- Display Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('category.update', $category->categoryid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-group">
                <label for="image">Category Image</label>
                <input type="file" name="image" class="form-control">
                @if($category->image)
                    <img src="{{ asset('uploads/'.$category->image) }}" alt="Category Image" style="width: 50px; height: 50px; object-fit: cover;">
                @endif
            </div>

            <button type="submit" class="btn btn-success">Update Category</button>
        </form>
    </div>
@endsection
