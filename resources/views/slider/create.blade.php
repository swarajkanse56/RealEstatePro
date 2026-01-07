@extends('back.master')

@section('content')
<div class="container mt-4">

    <h2>Add Slider</h2>
    <hr>

    <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Property Dropdown --}}
        <div class="mb-3">
            <label class="form-label">Select Property (Optional)</label>
            <select name="property_id" class="form-control">
                <option value="">-- General Slider (No Property) --</option>

                @foreach($properties as $property)
                    <option value="{{ $property->propertysid }}">
                        {{ $property->name }} - {{ $property->city->name ?? '' }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">If you select nothing, slider will be general.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Slider Image (Optional)</label>
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Upload Offer / Discount Image or Property Banner</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Example: Big Offer">
        </div>

        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" placeholder="Example: Special Discount on Flats">
        </div>

        <div class="mb-3">
            <label class="form-label">Discount Text</label>
            <input type="text" name="discount" class="form-control" placeholder="Example: 20% OFF">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Save Slider</button>
        <a href="{{ route('sliders.index') }}" class="btn btn-secondary mt-2">Cancel</a>
    </form>
</div>
@endsection
