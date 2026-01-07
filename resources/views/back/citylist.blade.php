@extends('back.master')

@section('title', 'City List')

@section('content')
<div class="container">
    <h2>City List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>S/N</th> <!-- Serial Number Column -->
                <th>Name</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cities as $city)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Serial Number -->
                    <td>{{ $city->name }}</td>
                    <td>
                        @if($city->image)
                            <img src="{{ asset($city->image) }}" width="60" alt="{{ $city->name }}">
                        @else
                            No image
                        @endif
                    </td>
                    <td>{{ $city->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('cities.edit', $city->citiesid ?? $city->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('cities.destroy', $city->citiesid ?? $city->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No cities found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
