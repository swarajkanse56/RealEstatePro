@extends('layout.app')

@section('title', 'Properties in ' . $category->name)

@section('content')
<!-- Page Heading -->
<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <span class="breadcrumb">
          <a href="/" style="color: #8B4513;">Home</a> /
          <a href="{{ route('properties.index') }}" style="color: #8B4513;">Properties</a> /
          {{ $category->name }}
        </span>
        <h3>Properties in {{ $category->name }}</h3>
      </div>
    </div>
  </div>
</div>

<!-- Properties Section -->
<div class="section properties py-5">
  <div class="container">
    <h3 class="text-center mb-4" style="color: #8B4513;">Explore "{{ $category->name }}" Properties</h3>
    <div class="text-center mb-4">
      <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">← Back to All Categories</a>
    </div>

    <div class="row">
      @forelse($properties as $property)
        <div class="col-lg-4 col-md-6 mb-4">
          <a href="/propertyv/{{ $property->propertysid }}" class="property-card" style="color: #8B4513;">
            <div class="card h-100 shadow-sm property-card">
              <img src="{{ asset('uploads/' . $property->image) }}" alt="{{ $property->name }}" class="card-img-top" style="height: 250px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title" style="color: #8B4513;">{{ $property->name }}</h5>
                <span class="badge bg-secondary mb-2">{{ $property->category->name ?? 'Uncategorized' }}</span>
                <h6 class="text-success">Rs. {{ number_format($property->price, 2) }}</h6>
                <ul class="list-unstyled small mt-3">
                  <li><strong>Address:</strong> {{ $property->address ?? 'N/A' }}</li>
                  <li><strong>Description:</strong> {{ \Illuminate\Support\Str::limit($property->description, 80) ?? 'N/A' }}</li>
                </ul>
              </div>
              <div class="card-footer bg-white text-center">
                <a href="{{ route('visit.create', ['property_id' => $property->propertysid]) }}" class="btn btn-primary w-100">Schedule a Visit</a>
              </div>
            </div>
          </a>
        </div>
      @empty
        <div class="col-12 text-center">
          <p class="text-muted">No properties found in this category.</p>
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .page-heading {
    background: linear-gradient(135deg, #8B4513, #8B4513);
    color: white;
    padding: 60px 0;
    text-align: center;
  }

  .breadcrumb {
    color: #fff;
    font-size: 14px;
  }

  .page-heading h3 {
    font-size: 36px;
    margin-top: 10px;
  }

  .property-card {
    border-radius: 10px;
    transition: all 0.3s ease-in-out;
  }

  .property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }

  .card-title {
    font-size: 20px;
    font-weight: 600;
  }

  .btn-primary {
    background-color: #8B4513;
    border-color: #8B4513;
  }

  .btn-primary:hover {
    background-color: #7a3a0c;
    border-color: #7a3a0c;
  }

  .badge.bg-secondary {
    background-color: #8B4513 !important;
  }

  @media (max-width: 768px) {
    .page-heading h3 {
      font-size: 28px;
    }

    .card-title {
      font-size: 18px;
    }
  }
</style>
@endsection
