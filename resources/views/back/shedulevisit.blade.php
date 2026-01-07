@extends('layout.app')

@section('title', 'Schedule a Visit')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-saddlebrown text-white py-3">
                    <h2 class="h4 mb-0 text-center">Schedule a Property Visit</h2>
                </div>
                
                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('visit.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Property Dropdown -->
                        <div class="mb-4">
                            <label for="property_id" class="form-label fw-bold">Select Property <span class="text-danger">*</span></label>
                            <select name="property_id" id="property_id" class="form-select form-select-lg" required>
                                <option value="" disabled selected>-- Choose a Property --</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->propertysid }}"
                                        data-category="{{ $property->category->categoryid ?? '' }}"
                                        @if($selectedProperty && $selectedProperty->propertysid == $property->propertysid) selected @endif>
                                        {{ $property->name }} - {{ $property->category->name ?? 'No Category' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a property</div>
                        </div>

                        <!-- Category Dropdown (Auto Selected) -->
                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-bold">Property Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                <option value="" disabled selected>-- Choose a Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->categoryid }}"
                                        {{ $selectedProperty && $selectedProperty->category && $selectedProperty->category->categoryid == $category->categoryid ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category</div>
                        </div>

                        <!-- Personal Information Section -->
                        <div class="border-top border-bottom py-4 mb-4">
                            <h5 class="text-saddlebrown mb-4">Your Information</h5>
                            
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg" required>
                                <div class="invalid-feedback">Please provide your name</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg" required>
                                <div class="invalid-feedback">Please provide a valid email</div>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control form-control-lg" required>
                                <div class="invalid-feedback">Please provide your phone number</div>
                            </div>
                        </div>

                        <!-- Visit Date -->
                        <div class="mb-4">
                            <label for="visit_date" class="form-label fw-bold">Preferred Visit Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="visit_date" class="form-control form-control-lg" required>
                            <div class="invalid-feedback">Please select a date and time</div>
                            <small class="text-muted">Our team will confirm your appointment within 24 hours</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-saddlebrown btn-lg py-3">
                                <i class="fas fa-calendar-check me-2"></i> Submit Visit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-select Category Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const propertySelect = document.getElementById('property_id');
        const categorySelect = document.getElementById('category_id');

        function updateCategorySelect() {
            const selectedOption = propertySelect.options[propertySelect.selectedIndex];
            const categoryId = selectedOption.getAttribute('data-category');
            if (categoryId) {
                categorySelect.value = categoryId;
            } else {
                categorySelect.selectedIndex = 0;
            }
        }

        propertySelect.addEventListener('change', updateCategorySelect);
        updateCategorySelect(); // trigger on load

        // Form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            
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
    });
</script>

<style>
    .bg-saddlebrown {
        background-color: #8B4513;
    }
    .btn-saddlebrown {
        background-color: #8B4513;
        color: white;
        border: none;
        transition: all 0.3s;
    }
    .btn-saddlebrown:hover {
        background-color: #6d3610;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .text-saddlebrown {
        color: #8B4513;
    }
    .form-control, .form-select {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        border-color: #8B4513;
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
    }
    .card {
        border-radius: 1rem;
        overflow: hidden;
    }
</style>
@endsection