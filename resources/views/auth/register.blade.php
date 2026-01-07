@extends('layouts.app')

@section('content')
<style>
    body {
        background: url('/images/real-estate-bg.jpg') no-repeat center center;
        background-size: cover;
    }

    .register-card {
        background-color: rgba(255, 255, 255, 0.96);
        border-radius: 1rem;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    .form-control {
        border-radius: 50px;
    }

    .btn-gold {
        background-color: #c9a635;
        color: white;
        border-radius: 50px;
        padding: 0.5rem 2rem;
    }

    .btn-gold:hover {
        background-color: #b8962d;
    }

    .register-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .register-header img {
        height: 60px;
    }

    .register-header h3 {
        margin-top: 1rem;
        font-weight: 600;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="register-card">
                <div class="register-header">
                     <h3>Create Your Account</h3>
                    <p class="text-muted">Join to list, browse, and manage properties</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password"
                               class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-gold">
                            {{ __('Register') }}
                        </button>
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            Already have an account?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
