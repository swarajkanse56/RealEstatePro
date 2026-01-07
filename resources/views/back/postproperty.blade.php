@extends('layout.app')

@section('title', 'Post Your Property')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-brown text-white py-4">
                    <h2 class="h4 mb-0 text-center"><i class="fas fa-home me-2"></i> Post Your Property</h2>
                </div>
                
                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h5 class="alert-heading">Please fix these errors:</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="row">
                            <!-- Property Information Section -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="text-brown mb-4 border-bottom pb-2 border-brown"><i class="fas fa-info-circle me-2"></i>Property Information</h5>
                                    
                                    <!-- Property Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Property Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-lg" id="name" value="{{ old('name') }}" required>
                                        <div class="invalid-feedback">Please provide a property name</div>
                                    </div>

                                    <!-- Sub Name -->
                                    <div class="mb-3">
                                        <label for="subname" class="form-label fw-bold">Sub Name</label>
                                        <input type="text" name="subname" class="form-control form-control-lg" id="subname" value="{{ old('subname') }}">
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-bold">Price (Rs) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-brown text-white">Rs</span>
                                            <input type="number" name="price" class="form-control form-control-lg" id="price" value="{{ old('price') }}" required>
                                        </div>
                                        <div class="invalid-feedback">Please provide a valid price</div>
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select form-select-lg" id="category_id" required>
                                            <option value="" disabled selected>Select a category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->categoryid }}" {{ old('category_id') == $category->categoryid ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a category</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information Section -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="text-brown mb-4 border-bottom pb-2 border-brown"><i class="fas fa-map-marker-alt me-2"></i>Location Information</h5>
                                    
                                    <!-- City -->
                                    <div class="mb-3">
                                        <label for="city_id" class="form-label fw-bold">City <span class="text-danger">*</span></label>
                                        <select name="city_id" class="form-select form-select-lg" id="city_id" required>
                                            <option value="" disabled selected>Select a city</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->citiesid }}" {{ old('city_id') == $city->citiesid ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a city</div>
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address <span class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control form-control-lg" id="address" rows="3" required>{{ old('address') }}</textarea>
                                        <div class="invalid-feedback">Please provide an address</div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label fw-bold">Contact Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control form-control-lg" id="phone" value="{{ old('phone') }}" required>
                                        <div class="invalid-feedback">Please provide a valid phone number</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="mb-4">
                            <h5 class="text-brown mb-4 border-bottom pb-2 border-brown"><i class="fas fa-align-left me-2"></i>Description</h5>
                            <textarea name="description" class="form-control form-control-lg" id="description" rows="5">{{ old('description') }}</textarea>
                            <small class="text-muted">Describe your property in detail (features, amenities, etc.)</small>
                        </div>

                        <!-- Images Section -->
                        <div class="mb-4">
                            <h5 class="text-brown mb-4 border-bottom pb-2 border-brown"><i class="fas fa-images me-2"></i>Property Images</h5>
                            
                            <!-- Main Image -->
                            <div class="mb-4">
                                <label for="image" class="form-label fw-bold">Main Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control form-control-lg" id="image" accept="image/*" required>
                                <div class="invalid-feedback">Please upload a main image</div>
                                <small class="text-muted">This will be the featured image of your property</small>
                            </div>

                            <!-- Gallery -->
                            <div class="mb-3">
                                <label for="gallery" class="form-label fw-bold">Additional Images</label>
                                <input type="file" name="gallery[]" class="form-control form-control-lg" id="gallery" multiple accept="image/*">
                                <small class="text-muted">Upload multiple images to showcase your property (max 10 images)</small>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-brown btn-lg py-3">
                                <i class="fas fa-paper-plane me-2"></i> Submit Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Validation Script -->
<script>
    (function () {
        'use strict'
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<style>
    :root {
        --brown: #8B4513;
        --brown-light: #d4a373;
        --brown-dark: #6d3610;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid var(--brown-light);
    }
    
    .card-header {
        border-radius: 0 !important;
    }
    
    .bg-brown {
        background-color: var(--brown) !important;
    }
    
    .btn-brown {
        background-color: var(--brown);
        color: white;
        border: none;
    }
    
    .btn-brown:hover {
        background-color: var(--brown-dark);
        color: white;
    }
    
    .text-brown {
        color: var(--brown) !important;
    }
    
    .border-brown {
        border-color: var(--brown) !important;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--brown);
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
    }
    
    .form-control-lg {
        padding: 0.75rem 1rem;
    }
    
    .invalid-feedback {
        font-size: 0.875em;
        color: #dc3545;
    }
    
    .input-group-text {
        background-color: var(--brown);
        color: white;
        border: none;
    }
    
    .alert {
        border-radius: 8px;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c2c7;
    }
    
    .alert-success {
        background-color: #d1e7dd;
        border-color: #badbcc;
    }
</style>
@endsection