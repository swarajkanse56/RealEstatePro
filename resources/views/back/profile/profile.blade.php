@extends('back.master')
@section('title', 'Profile')
@section('content')
<style>
    .profile-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 20px;
        background-color: #f8f9fa;
    }

    .profile-card {
        width: 100%;
        max-width: 700px;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .profile-header {
        background: linear-gradient(135deg, #0e85e1);
        color: white;
        padding: 40px 30px;
        text-align: center;
        position: relative;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 0;
        right: 0;
        height: 40px;
        background: white;
        clip-path: ellipse(65% 50% at 50% 50%);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: #667eea;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 24px;
    }

    .profile-body {
        padding: 40px;
    }

    .profile-detail {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .profile-detail:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        color: #667eea;
        font-size: 20px;
    }

    .detail-content {
        flex: 1;
    }

    .detail-content h5 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #7a7a7a;
        font-weight: 500;
    }

    .detail-content p {
        margin: 0;
        font-size: 18px;
        color: #333;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-weight: 500;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(0, 0, 0, 0.15);
    }

    .btn-back {
        background: linear-gradient(135deg, #2c3e50 0%, #1a242f 100%);
        color: white;
    }

    .btn-update {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .btn i {
        margin-right: 8px;
    }

    @media (max-width: 576px) {
        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h4>{{ $user->name }}'s Profile</h4>
        </div>
        <div class="profile-body">
            <div class="profile-detail">
                <div class="detail-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="detail-content">
                    <h5>Full Name</h5>
                    <p>{{ $user->name }}</p>
                </div>
            </div>

            <div class="profile-detail">
                <div class="detail-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="detail-content">
                    <h5>Email Address</h5>
                    <p>{{ $user->email }}</p>
                </div>
            </div>

            @if(!empty($user->phone))
            <div class="profile-detail">
                <div class="detail-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="detail-content">
                    <h5>Phone Number</h5>
                    <p>{{ $user->phone }}</p>
                </div>
            </div>
            @endif

            @if(!empty($user->address))
            <div class="profile-detail">
                <div class="detail-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="detail-content">
                    <h5>Address</h5>
                    <p>{{ $user->address }}</p>
                </div>
            </div>
            @endif

            <div class="action-buttons">
                <a href="{{ url()->previous() }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

                @auth
                    @if(Auth::id() === $user->id)
                    <a href="{{ route('profile.edit') }}" class="btn btn-update">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
