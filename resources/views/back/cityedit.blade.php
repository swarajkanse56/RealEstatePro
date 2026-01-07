@extends('back.master')

@section('title', 'Edit City')

@section('content')
<div class="container">
    <h2>Edit City</h2>

    <form action="{{ route('cities.update', $city->citiesid ?? $city->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">City Name</label>
            <input type="text" name="name" class="form-control" value="{{ $city->name }}">
        </div>

        <div class="mb-3">
            <label for="image">City Image</label>
            @if($city->image)
                <div>
                    <img src="{{ asset($city->image) }}" width="100">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-success">Update City</button>
        <a href="{{ route('cities.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
