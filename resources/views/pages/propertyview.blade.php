@extends('layout.app')

@section('title', $property->name)

@section('content')
<div class="container mt-5">

    <!-- Page Heading -->
    <h2 class="text-center mb-5">{{ $property->name }} Details</h2>

    <div class="row">
        <!-- Left Column: Images -->
        <div class="col-md-6 mb-4">
            <div class="d-flex">
                @php
                    $galleryImages = [];
                    if (!empty($property->gallery) && is_string($property->gallery)) {
                        $decoded = json_decode($property->gallery, true);
                        if (is_array($decoded)) {
                            $galleryImages = $decoded;
                        }
                    }
                @endphp

                @if($property->image || count($galleryImages) > 0)
                    <div class="me-3 d-flex flex-column overflow-auto" style="max-height: 400px; gap: 10px;">
                        @if($property->image)
                            <img src="{{ asset('uploads/' . $property->image) }}" alt="Main Image"
                                 class="img-thumbnail gallery-thumb"
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                 onclick="document.getElementById('mainProductImage').src='{{ asset('uploads/' . $property->image) }}'">
                        @endif
                        @foreach($galleryImages as $img)
                            <img src="{{ asset('uploads/' . $img) }}" alt="Gallery Image"
                                 class="img-thumbnail gallery-thumb"
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                 onclick="document.getElementById('mainProductImage').src='{{ asset('uploads/' . $img) }}'">
                        @endforeach
                    </div>
                @endif

                <div class="flex-grow-1">
                    @if($property->image)
                        <img id="mainProductImage" src="{{ asset('uploads/' . $property->image) }}" alt="{{ $property->name }}"
                             class="img-fluid rounded shadow" style="height: 400px; object-fit: cover; width: 100%;">
                    @else
                        <div class="alert alert-warning">No Image Available</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Info -->
        <div class="col-md-6">
            <div class="bg-light p-4 rounded shadow-sm">
                <h3 class="mb-3 text-center">{{ $property->name }}</h3>
                <h4 class="text-primary text-center mb-4">Rs. {{ number_format($property->price, 2) }}</h4>
                <p><strong>Subname:</strong> {{ $property->subname ?? 'N/A' }}</p>
                <p><strong>Category:</strong> {{ $property->category->name ?? 'N/A' }}</p>
                <p><strong>Description:</strong><br>{{ $property->description ?? 'No description available.' }}</p>
                <p><strong>City:</strong> {{ $property->city->name ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $property->address ?? 'N/A' }}</p>

                <!-- Owner Info -->
                <hr>
                <h5 class="mt-4">Owner Details</h5>
                <p><strong>Name:</strong> {{ $property->user->name ?? 'N/A' }}</p>

                @php
                    $phonesRaw = $property->phone ?? '';
                    $phones = [];

                    $decoded = json_decode($phonesRaw, true);
                    if (is_array($decoded)) {
                        $phones = $decoded;
                    } elseif (!empty($phonesRaw)) {
                        $phones = [$phonesRaw];
                    }
                @endphp

                <p><strong>Phone:</strong>
                    @if(count($phones) > 0)
                        {{ implode(', ', $phones) }}
                    @else
                        N/A
                    @endif
                </p>

                <div class="text-center mt-4">
                    <a href="/schedule-visit?property_id={{ $property->propertysid }}" class="btn btn-primary btn-lg px-5 rounded-pill">
                        Schedule a Visit
                    </a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">Back to Property List</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Owner Card -->
    <div class="card shadow mt-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-center text-md-start mb-2 mb-md-0">
                    <h4 class="mb-1">Contact Property Owner</h4>
                    <div class="owner-badge bg-white text-primary px-3 py-1 rounded-pill d-inline-block">
                        <i class="fas fa-user-circle me-2"></i>
                        <span class="fw-bold">
                            @if(isset($property->user))
                                <a href="{{ route('user.profile', $property->user->id) }}" class="text-primary text-decoration-none">
                                    {{ $property->user->name }}
                                </a>
                            @else
                                Owner Not Specified
                            @endif
                        </span>
                    </div>
                </div>
                <div class="owner-rating mt-2 mt-md-0">
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="ms-2">4.8</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Methods -->
        <div class="card-body">
            <div class="row text-center">
                <!-- Call -->
                <div class="col-md-4 mb-4">
                    <div class="contact-method p-3 h-100">
                        <div class="icon-container bg-primary-light rounded-circle p-3 mb-3 mx-auto">
                            <i class="fas fa-phone fa-lg text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Call Owner</h5>
                        @if(count($phones) > 0)
                            @foreach($phones as $phone)
                                <a href="tel:{{ $phone }}" class="btn btn-outline-primary rounded-pill px-4 mb-2 w-75">
                                    <i class="fas fa-phone me-2"></i> {{ $phone }}
                                </a>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">No phone available</p>
                        @endif
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-4 mb-4">
                    <div class="contact-method p-3 h-100">
                        <div class="icon-container bg-primary-light rounded-circle p-3 mb-3 mx-auto">
                            <i class="fas fa-envelope fa-lg text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Email Owner</h5>
                        @if($property->user->email ?? false)
                            <a href="mailto:{{ $property->user->email }}" class="btn btn-outline-primary rounded-pill px-4 w-75">
                                <i class="fas fa-envelope me-2"></i> Send Message
                            </a>
                        @else
                            <p class="text-muted mb-0">No email available</p>
                        @endif
                    </div>
                </div>

                <!-- Schedule -->
                <div class="col-md-4 mb-4">
                    <div class="contact-method p-3 h-100">
                        <div class="icon-container bg-primary-light rounded-circle p-3 mb-3 mx-auto">
                            <i class="fas fa-calendar-check fa-lg text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Schedule Visit</h5>
                        <a href="/schedule-visit?property_id={{ $property->propertysid }}" class="btn btn-primary rounded-pill px-4 w-75">
                            <i class="fas fa-calendar me-2"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Message -->
        <div class="card-footer bg-light">
            <div class="text-center">
                <button class="btn btn-link text-primary" data-bs-toggle="collapse" data-bs-target="#quickMessageForm">
                    <i class="fas fa-comment-dots me-2"></i> Send Quick Message
                </button>
                <div id="quickMessageForm" class="collapse mt-3">
                    <form>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="messageSubject" placeholder="Subject">
                            <label for="messageSubject">Subject</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Your message" id="messageText" style="height: 100px"></textarea>
                            <label for="messageText">Your Message</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .owner-badge {
        font-size: 0.9rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .icon-container {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }
    .contact-method {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .contact-method:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection
