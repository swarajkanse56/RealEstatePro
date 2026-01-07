@extends('back.master')

@section('title', 'View Property')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Property Details</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row align-items-start">
                <!-- Left Column: Main Image -->
                <div class="col-md-5 mb-4 mb-md-0 text-center">
                    @if($property->image)
                        <img id="mainProductImage" src="{{ asset('uploads/' . $property->image) }}" alt="Property Image" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="alert alert-warning">No Main Image Available</div>
                    @endif

                    <!-- Horizontal Gallery -->
                    @if($property->gallery && count(json_decode($property->gallery, true)) > 0)
                        <h5 class="mt-4 mb-3">Gallery</h5>
                        <div style="display: flex; overflow-x: auto; gap: 10px; padding-bottom: 10px;">
                            <!-- Main image thumbnail -->
                            @if($property->image)
                                <div style="flex: 0 0 auto; cursor: pointer;">
                                    <img src="{{ asset('uploads/' . $property->image) }}" alt="Main Image"
                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;"
                                         onclick="document.getElementById('mainProductImage').src='{{ asset('uploads/' . $property->image) }}'">
                                </div>
                            @endif

                            <!-- Gallery thumbnails -->
                            @foreach(json_decode($property->gallery, true) as $img)
                                <div style="flex: 0 0 auto; cursor: pointer;">
                                    <img src="{{ asset('uploads/' . $img) }}" alt="Gallery Image"
                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;"
                                         onclick="document.getElementById('mainProductImage').src='{{ asset('uploads/' . $img) }}'">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column: Property Details -->
                <div class="col-md-7">
                    <h4 class="mb-3">{{ $property->name }}</h4>

                    <p><strong>Subname:</strong> {{ $property->subname ?? 'N/A' }}</p>
                    <p><strong>Price:</strong> Rs.{{ number_format($property->price, 2) }}</p>
                    <p><strong>Category:</strong> {{ $property->category->name ?? 'No Category' }}</p>
                    <p><strong>City:</strong> {{ $property->city->name ?? 'No City' }}</p>
                    <p><strong>Address:</strong> {{ $property->address ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $property->phone ?? 'N/A' }}</p>
                    <p><strong>Description:</strong><br>{{ $property->description ?? 'No description available.' }}</p>

                    <a href="{{ route('property.list') }}" class="btn btn-secondary mt-3">Back to Property List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
