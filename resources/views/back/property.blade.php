@extends('layout.app')

@section('title', 'Properties')

@section('content')

<!-- Header -->
<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <span class="breadcrumb">
          <a href="#" style="color: #8B4513;">Home</a> / Properties
        </span>
        <h2 class="mt-2" style="color: #8B4513;">Discover Your Perfect Property</h2>
      </div>
    </div>
  </div>
</div>

<!-- Properties Section -->
<div class="section properties py-5">
  <div class="container">

    <!-- City Filter -->
    <div class="mb-5">
      <h4 class="text-center" style="color: #8B4513;">Select Your City:</h4>
      <form method="GET" action="{{ url('/properties') }}">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">
            <select name="city_id" class="form-select form-select-lg" onchange="this.form.submit()">
              <option value="">-- Select City --</option>
              @foreach($cities as $city)
                <option value="{{ $city->citiesid }}" {{ request('city_id') == $city->citiesid ? 'selected' : '' }}>
                  {{ $city->name }}
                </option>
              @endforeach
            </select>

            @if(request('category_id'))
              <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
          </div>
        </div>
      </form>
    </div>

    <!-- Categories -->
    <h3 class="text-center my-5" style="color: #8B4513;">Browse Properties by Categories</h3>
    <div class="row justify-content-center mb-5 gx-4 gy-4">
      @foreach($categories as $category)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <a href="{{ url('/properties') }}?category_id={{ $category->categoryid }}{{ request('city_id') ? '&city_id=' . request('city_id') : '' }}" class="text-decoration-none category-card-link">
            <div class="card category-card shadow-sm text-center h-100 border-0 rounded-4 overflow-hidden transition">
              <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                <i class="fas fa-building fa-3x mb-4" style="color: #8B4513;"></i>
                <h5 class="card-title" style="color: #8B4513; font-weight: 700;">{{ $category->name }}</h5>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>

    <!-- Property Listings -->
    <div class="row">
      @foreach($properties as $property)
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card shadow-sm border-0 h-100">
            <a href="/propertyv/{{ $property->propertysid }}">
              <img src="{{ asset('uploads/' . $property->image) }}" class="card-img-top img-fluid" alt="{{ $property->name }}" style="height: 200px; object-fit: cover;">
            </a>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="card-title mb-0" style="color: #8B4513;">{{ $property->name }}</h5>
              </div>
              <p class="mb-1" style="color: #555;">
                <strong>Location:</strong> {{ $property->address ?? 'N/A' }}, {{ $property->city->name ?? 'N/A' }}
              </p>
              {{-- Uncomment below if you want to show size --}}
              {{-- <p class="mb-1" style="color: #555;"><strong>Size:</strong> {{ $property->size ?? '1000 - 2500 sq.ft.' }}</p> --}}
              <p class="fw-bold mt-2 mb-2" style="color: #8B4513;">
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
  .category-button {
    background-color: #8B4513;
    padding: 6px 15px;
    border-radius: 20px;
    text-transform: capitalize;
    font-weight: 600;
    color: white !important;
    text-decoration: none;
  }

  .category-button:hover {
    background-color: #9a3e00;
    color: white !important;
  }

  .form-select {
    border: 2px solid #8B4513;
    color: #8B4513;
  }

  .form-select:focus {
    box-shadow: 0 0 5px #8B4513;
    border-color: #8B4513;
  }

  .card-title {
    font-size: 1rem;
    font-weight: 600;
  }

  .card-body p {
    font-size: 0.9rem;
    margin-bottom: 0.4rem;
  }

  .card:hover {
    transform: translateY(-5px);
    transition: 0.3s ease;
  }

  .btn-outline-primary {
    border-color: #8B4513;
    color: #8B4513;
  }

  .btn-outline-primary:hover {
    background-color: #8B4513;
    color: #fff;
  }

  /* Category card improvements */
  .category-card {
    background: #fff;
    border: 2px solid #8B4513;
    box-shadow: 0 4px 8px rgba(139, 69, 19, 0.15);
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 12px;
  }

  .category-card:hover {
    background: #8B4513;
    box-shadow: 0 8px 16px rgba(139, 69, 19, 0.35);
    transform: translateY(-8px);
  }

  .category-card:hover .card-title,
  .category-card:hover i {
    color: #fff !important;
    transition: color 0.3s ease;
  }

  .category-card-link {
    display: block;
    height: 100%;
    text-decoration: none;
  }

  /* Responsive tweaks */
  @media (max-width: 576px) {
    .category-card {
      margin-bottom: 20px;
    }
  }
</style>
@endsection
