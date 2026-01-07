@extends('back.master')

@section('title', 'Post Property')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-brown text-white py-3">
                    <h5 class="mb-0 text-center"><i class="fas fa-home me-2"></i>Post Your Property</h5>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="row g-3">
                            <!-- Property Info -->
                            <div class="col-md-6">
                                <h6 class="text-brown mb-3"><i class="fas fa-info-circle me-1"></i>Property Info</h6>

                                <div class="mb-2">
                                    <label for="name" class="form-label small">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-sm" id="name" value="{{ old('name') }}" required>
                                    <div class="invalid-feedback">Enter property name</div>
                                </div>

                                <div class="mb-2">
                                    <label for="subname" class="form-label small">Sub Name</label>
                                    <input type="text" name="subname" class="form-control form-control-sm" id="subname" value="{{ old('subname') }}">
                                </div>

                                <div class="mb-2">
                                    <label for="price" class="form-label small">Price (Rs) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-brown text-white">Rs</span>
                                        <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" required>
                                    </div>
                                    <div class="invalid-feedback">Enter valid price</div>
                                </div>

                                <div class="mb-2">
                                    <label for="category_id" class="form-label small">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select form-select-sm" required>
                                        <option value="" disabled selected>Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->categoryid }}" {{ old('category_id') == $category->categoryid ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Choose a category</div>
                                </div>
                            </div>

                            <!-- Location Info -->
                            <div class="col-md-6">
                                <h6 class="text-brown mb-3"><i class="fas fa-map-marker-alt me-1"></i>Location Info</h6>

                                <div class="mb-2">
                                    <label for="city_id" class="form-label small">City <span class="text-danger">*</span></label>
                                    <select name="city_id" class="form-select form-select-sm" required>
                                        <option value="" disabled selected>Select city</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->citiesid }}" {{ old('city_id') == $city->citiesid ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Choose a city</div>
                                </div>

                                <div class="mb-2">
                                    <label for="address" class="form-label small">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" class="form-control form-control-sm" rows="2" required>{{ old('address') }}</textarea>
                                    <div class="invalid-feedback">Enter address</div>
                                </div>

                                <div class="mb-2">
                                    <label for="phone" class="form-label small">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control form-control-sm" id="phone" value="{{ old('phone') }}" required>
                                    <div class="invalid-feedback">Enter phone number</div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <h6 class="text-brown mb-2"><i class="fas fa-align-left me-1"></i>Description</h6>
                            <textarea name="description" class="form-control form-control-sm" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <!-- Images -->
                        <div class="mb-3">
                            <h6 class="text-brown mb-2"><i class="fas fa-images me-1"></i>Images</h6>

                            <div class="mb-2">
                                <label for="image" class="form-label small">Main Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control form-control-sm" required>
                                <div class="invalid-feedback">Upload main image</div>
                            </div>

                            <div>
                                <label for="gallery" class="form-label small">Gallery</label>
                                <input type="file" name="gallery[]" class="form-control form-control-sm" multiple>
                                <small class="text-muted small">Max 10 images</small>
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-brown btn-sm py-2">
                                <i class="fas fa-paper-plane me-1"></i>Submit Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --brown: #8B4513;
        --brown-dark: #6d3610;
    }

    .bg-brown { background-color: var(--brown); }
    .text-brown { color: var(--brown); }
    .btn-brown {
        background-color: var(--brown);
        color: #fff;
        border: none;
    }
    .btn-brown:hover { background-color: var(--brown-dark); }

    .form-control, .form-select {
        border-radius: 6px;
    }
</style>

<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endsection
