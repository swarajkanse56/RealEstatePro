@extends('back.master')

@section('title', 'Send Notification')

@section('content')
<div class="container mt-4">

    <h3>Send Notification</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('send.notification') }}">
        @csrf

        <div class="mb-3">
            <label>Notification Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select Property</label>

            {{-- ✅✅✅ IMPORTANT FIX IS HERE --}}
            <select name="property_id" class="form-control" required>
                <option value="">-- Select Property --</option>

                @foreach($properties as $property)
                    <option value="{{ $property->propertysid }}">
                        {{ $property->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <button type="submit" class="btn btn-success">
            Send Notification
        </button>

    </form>

</div>
@endsection
