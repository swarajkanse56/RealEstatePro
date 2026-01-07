@extends('back.master')

@section('title', 'Edit Property')

@section('content')
<div class="container mt-4">
    <h2>Edit Property</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('property.update', $property->propertysid) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="form-group mb-3">
            <label for="name">Property Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $property->name) }}" required>
        </div>

        <!-- Subname -->
        <div class="form-group mb-3">
            <label for="subname">Subname</label>
            <input type="text" name="subname" class="form-control" value="{{ old('subname', $property->subname) }}">
        </div>

        <!-- Price -->
        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $property->price) }}" required>
        </div>

        <!-- Category -->
        <div class="form-group mb-3">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->categoryid }}" {{ old('category_id', $property->category_id) == $category->categoryid ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- City -->
        <div class="form-group mb-3">
            <label for="city_id">City</label>
            <select name="city_id" class="form-control" required>
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->citiesid }}" {{ old('city_id', $property->city_id) == $city->citiesid ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Address -->
        <div class="form-group mb-3">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" rows="3" required>{{ old('address', $property->address) }}</textarea>
        </div>

        <!-- Phone -->
        <div class="form-group mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $property->phone) }}" required>
        </div>

        <!-- Description -->
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $property->description) }}</textarea>
        </div>

        <!-- Main Image -->
        <div class="form-group mb-3">
            <label for="image">Main Image</label>
            <input type="file" name="image" class="form-control">
            @if ($property->image)
                <div class="mt-2">
                    <img src="{{ asset('uploads/' . $property->image) }}" alt="Main Image" width="120">
                </div>
            @endif
        </div>

        <!-- Gallery Images -->
        <div class="form-group mb-3">
            <label for="gallery">Gallery Images (Add more)</label>
            <input type="file" name="gallery[]" class="form-control" multiple>
            @if ($property->gallery)
                <div class="mt-3 d-flex flex-wrap gap-2">
                    @foreach (json_decode($property->gallery, true) as $galleryImage)
                        <img src="{{ asset('uploads/' . $galleryImage) }}" alt="Gallery Image" width="100">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Submit -->
        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Update Property</button>
            <a href="{{ route('property.list') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
