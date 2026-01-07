@extends('layout.app')

@section('title', 'Properties')

@section('content')

<!-- Header -->
<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <span class="breadcrumb">
          <a href="{{ url('/') }}">Home</a> / Properties
        </span>
        <h2 class="mt-2" style="color: white">Discover Your Perfect Property</h2>
      </div>
    </div>
  </div>
</div>

<!-- Properties Section -->
<div class="section properties py-5">
  <div class="container">

    <!-- Filter Form -->
    <section class="position-relative z-index-2">
      <div class="container">
        <div class="search-card bg-white rounded-4 shadow-lg p-4 p-lg-5 mt-n5 mx-auto" style="max-width: 1200px;">
          <h3 class="h5 text-center text-muted mb-4">FIND YOUR PERFECT PROPERTY</h3>
          <form action="{{ url('/properties') }}" method="GET" class="row g-3">

            <!-- Category -->
            <div class="col-md-3">
              <div class="form-floating">
                <select name="category_id" class="form-select border-0 bg-light" id="categorySelect">
                  <option value="">All Categories</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->categoryid }}" {{ request('category_id') == $category->categoryid ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                <label for="categorySelect" class="text-muted small">CATEGORY</label>
              </div>
            </div>

            <!-- City -->
            <div class="col-md-3">
              <div class="form-floating">
                <select name="city_id" class="form-select border-0 bg-light" id="citySelect">
                  <option value="">All Cities</option>
                  @foreach($cities as $city)
                    <option value="{{ $city->citiesid }}" {{ request('city_id') == $city->citiesid ? 'selected' : '' }}>
                      {{ $city->name }}
                    </option>
                  @endforeach
                </select>
                <label for="citySelect" class="text-muted small">CITY</label>
              </div>
            </div>

            <!-- Price Range -->
            <div class="col-md-3">
              <div class="form-floating">
                <select name="price_range" class="form-select border-0 bg-light" id="priceSelect">
                  <option value="">Any Price</option>
                  <option value="0-500000">Under Rs. 500,000</option>
                  <option value="500000-1000000">Rs. 500,000 - 1,000,000</option>
                  <option value="1000000-2000000">Rs. 1,000,000 - 2,000,000</option>
                  <option value="2000000-5000000">Rs. 2,000,000 - 5,000,000</option>
                  <option value="5000000-10000000">Rs. 5,000,000 - 10,000,000</option>
                  <option value="10000000-">Over Rs. 10,000,000</option>
                </select>
                <label for="priceSelect" class="text-muted small">PRICE RANGE</label>
              </div>
            </div>

            <!-- Search Button -->
            <div class="col-md-3 d-grid">
              <button type="submit" class="btn btn-dark btn-lg h-100">
                <i class="fas fa-search me-2"></i> SEARCH
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- Property Listings -->
    <div class="row mt-5">
      @foreach($properties as $property)
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card shadow-sm border-0 h-100">
            <a href="/propertyv/{{ $property->propertysid }}">
              <img src="{{ asset('uploads/' . $property->image) }}" class="card-img-top img-fluid" alt="{{ $property->name }}" style="height: 200px; object-fit: cover;">
            </a>
            <div class="card-body">
              <h5 class="card-title">{{ $property->name }}</h5>
              <p><strong>Location:</strong> {{ $property->address ?? 'N/A' }}, {{ $property->city->name ?? 'N/A' }}</p>
              <p class="fw-bold text-dark mt-2 mb-2">
                Rs. {{ number_format($property->min_price ?? $property->price, 2) }} - {{ number_format($property->max_price ?? $property->price, 2) }}
              </p>
              <div class="text-center">
                <a href="/propertyv/{{ $property->propertysid }}" class="btn btn-outline-primary w-100">Contact Now</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      {{ $properties->appends(request()->query())->links() }}
    </div>

  </div>
</div>

@endsection

@section('styles')
<style>
  /* Header Styling */
  .page-heading {
    background-color: #f5f1ec;
    padding: 60px 0;
  }

  .breadcrumb a {
    color: #8B4513;
    text-decoration: none;
    font-weight: 500;
  }

  .breadcrumb a:hover {
    text-decoration: underline;
  }

  h2 {
    font-weight: 700;
    font-size: 2.5rem;
    color: #8B4513;
  }

  /* Form & Filters */
  .form-select {
    border: 2px solid #8B4513;
    color: #8B4513;
  }

  .form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
    border-color: #8B4513;
  }

  .btn-dark {
    background-color: #8B4513;
    border: none;
  }

  .btn-dark:hover {
    background-color: #9a3e00;
  }

  /* Property Cards */
  .card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #8B4513;
  }

  .card-body p {
    font-size: 0.9rem;
    color: #444;
    margin-bottom: 0.4rem;
  }

  .card:hover {
    transform: translateY(-5px);
    transition: 0.3s ease;
  }

  .card-img-top {
    transition: transform 0.3s ease;
  }

  .card:hover .card-img-top {
    transform: scale(1.03);
  }

  .btn-outline-primary {
    border-color: #8B4513;
    color: #8B4513;
  }

  .btn-outline-primary:hover {
    background-color: #8B4513;
    color: #fff;
  }

  /* Pagination */
  .pagination .page-item.active .page-link {
    background-color: #8B4513;
    border-color: #8B4513;
  }

  .pagination .page-link {
    color: #8B4513;
  }

  /* Responsive Adjustments */
  @media (max-width: 767.98px) {
    .form-floating {
      margin-bottom: 1rem;
    }

    .btn-lg {
      font-size: 1rem;
      padding: 0.6rem 1rem;
    }

    .card-title {
      font-size: 0.95rem;
    }
  }
</style>
@endsection
