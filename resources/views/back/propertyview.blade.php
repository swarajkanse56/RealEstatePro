@extends('layout.app')

@section('title', $property->name)

@section('content')
<div class="container mt-5">
    <!-- Title -->
    <h2 class="text-center mb-4">{{ $property->name }} Details</h2>

    <div class="row align-items-start">
        <!-- Left Column: Gallery + Image -->
        <div class="col-md-6 mb-4">
            <div class="d-flex flex-row">
                <!-- Gallery Thumbnails (Left side) -->
                @if($property->gallery && count(json_decode($property->gallery, true)) > 0)
                    <div class="d-flex flex-column align-items-start overflow-auto pe-3" style="max-height: 400px; gap: 10px;">
                        <!-- Main image thumbnail -->
                        @if($property->image)
                            <img src="{{ asset('uploads/' . $property->image) }}" alt="Main Image"
                                 class="img-thumbnail gallery-thumb"
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer;"
                                 onclick="document.getElementById('mainProductImage').src='{{ asset('uploads/' . $property->image) }}'">
                        @endif

                        <!-- Gallery thumbnails -->
                        @foreach(json_decode($property->gallery, true) as $img)
                            <img src="{{ asset('uploads/' . $img) }}" alt="Gallery Image"
                                 class="img-thumbnail gallery-thumb"
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer;"
                                 onclick="document.getElementById('mainProductImage').src='{{ asset('uploads/' . $img) }}'">
                        @endforeach
                    </div>
                @endif

                <!-- Main Image (Right of gallery) -->
                <div class="flex-grow-1">
                    @if($property->image)
                        <img id="mainProductImage" src="{{ asset('uploads/' . $property->image) }}" alt="{{ $property->name }}"
                             class="img-fluid rounded shadow-lg" style="height: 400px; object-fit: cover; width: 100%;">
                    @else
                        <div class="alert alert-warning text-center">No Image Available</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Property Info -->
        <div class="col-md-6">
            <div class="bg-light p-4 rounded shadow-sm">
                <div class="mb-4 text-center">
                    <h3 class="text-dark">{{ $property->name }}</h3>
                    <h4 class="text-primary">Rs.{{ number_format($property->price, 2) }}</h4>
                    <hr>
                </div>

                <div class="mb-3">
                    <p><strong>Subname:</strong> {{ $property->subname ?? 'N/A' }}</p>
                    <p><strong>Category:</strong> {{ $property->category->name ?? 'No Category' }}</p>
                    <p><strong>Description:</strong><br>{{ $property->description ?? 'No description available.' }}</p>
                </div>

                <div class="mb-3">
                    <p><strong>City:</strong> {{ $property->city->name ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $property->address ?? 'N/A' }}</p>
                                        <p><strong>Phone:</strong> {{ $property->phone ?? 'N/A' }}</p>

                </div>

                <div class="text-center mt-4">
                    <a href="/schedule-visit?property_id={{ $property->propertysid }}" class="btn btn-primary btn-lg rounded-pill px-5">Schedule a Visit</a>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary btn-lg px-4 py-2">Back to Property List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    .container {
        max-width: 1200px;
    }

    h2, h3, h4 {
        color: #333;
    }

    h2 {
        font-size: 2.5rem;
        font-weight: 600;
    }

    h3 {
        font-size: 2rem;
    }

    h4 {
        font-size: 1.8rem;
        font-weight: 500;
        color: #007bff;
    }

    .img-fluid {
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .bg-light {
        background-color: #f7f7f7;
    }

    .shadow-sm {
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-primary, .btn-outline-secondary {
        font-size: 18px;
        border-radius: 25px;
        padding: 12px 40px;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    p {
        font-size: 1rem;
        color: #555;
        line-height: 1.6;
    }

    .gallery-thumb:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        h2 { font-size: 2rem; }
        h3 { font-size: 1.8rem; }
        h4 { font-size: 1.6rem; }
    }

    @media (max-width: 576px) {
        .container { padding: 0 15px; }
        .btn-lg { font-size: 16px; padding: 10px 25px; }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection
