@extends('back.master')

@section('title', 'Add City')

@section('content')
<div class="container mt-4">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add City</h4>
        </div>

        <div class="card-body">

            {{-- ✅ SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ VALIDATION ERRORS --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ✅ CITY NAME --}}
                <div class="mb-3">
                    <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        placeholder="Enter city name"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- ✅ CITY IMAGE --}}
                <div class="mb-3">
                    <label for="image" class="form-label">City Image (Optional)</label>
                    <input 
                        type="file" 
                        class="form-control @error('image') is-invalid @enderror" 
                        id="image" 
                        name="image"
                        accept="image/*"
                    >

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- ✅ SUBMIT BUTTON --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        ✅ Add City
                    </button>

                    <a href="{{ route('cities.index') }}" class="btn btn-secondary ms-2">
                        🔙 Back
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
