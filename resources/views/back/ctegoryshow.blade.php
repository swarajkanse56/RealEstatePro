@extends('back.master')

@section('title', 'Category List')

@section('content')
    <div class="container">
        <h1>Categories</h1>

        <!-- Check if there are categories -->
        @if($category->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category as $cat)
                        <tr>
                            <td>{{ $cat->categoryid }}</td> <!-- Display the custom category ID -->
                            <td>{{ $cat->name }}</td>
                            <td>
                                @if($cat->image)
                                    <img src="{{ asset('uploads/'.$cat->image) }}" alt="Category Image" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    No image available
                                @endif
                            </td>
                            <td>
                                <!-- You can add buttons for edit, delete, etc. -->
                                <a href="{{ route('category.edit', $cat->categoryid) }}" class="btn btn-primary">Edit</a>
                                
                                <!-- Delete button (uncomment if needed) -->
                                <form action="{{ route('category.destroy', $cat->categoryid) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No categories found.</p>
        @endif
    </div>
@endsection
