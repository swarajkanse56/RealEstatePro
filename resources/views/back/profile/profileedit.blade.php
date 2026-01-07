@extends('back.master')

@section('content')
<style>
    .edit-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 20px;
        background-color: #f8f9fa;
    }

    .edit-card {
        width: 100%;
        max-width: 700px;
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    }

    .edit-card h3 {
        margin-bottom: 30px;
        text-align: center;
        font-weight: 700;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
        margin-bottom: 6px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        font-weight: 600;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        width: 100%;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(0, 0, 0, 0.15);
    }

    .btn-back {
        display: block;
        margin-top: 15px;
        text-align: center;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }
</style>

<div class="edit-container">
    <div class="edit-card">
        <h3>Edit Profile</h3>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
            </div>

             
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control">{{ old('address', Auth::user()->address) }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Save Changes</button>
            <a href="{{ route('profile.show') }}" class="btn-back">← Cancel and go back</a>
        </form>
    </div>
</div>
@endsection
