@extends('layout.app')

@section('title', 'Property Form')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Add Property</h2>
    <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Property Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Property dame</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <!-- Sub Name -->
        <div class="mb-3">
            <label for="subname" class="form-label">Sub Name</label>
            <input type="text" name="subname" class="form-control" id="subname" value="{{ old('subname') }}">
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price (Rs)</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" required>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-control" id="category_id" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->categoryid }}" {{ old('category_id') == $category->categoryid ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- City -->
        <div class="mb-3">
            <label for="city_id" class="form-label">City</label>
            <select name="city_id" class="form-control" id="city_id" required>
                <option value="">Select a city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->citiesid }}" {{ old('city_id') == $city->citiesid ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control" id="address" rows="4">{{ old('address') }}</textarea>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}" required>
        </div>

        <!-- Main Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Main Image</label>
            <input type="file" name="image" class="form-control" id="image" accept="image/*">
        </div>

        <!-- Gallery -->
        <div class="mb-3">
            <label for="gallery" class="form-label">Gallery Images (Multiple)</label>
            <input type="file" name="gallery[]" class="form-control" id="gallery" multiple accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
