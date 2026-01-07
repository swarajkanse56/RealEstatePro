@extends('layout.app')

@section('title', $user->name . ' Profile')

@section('content')
<style>
    .profile-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .profile-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
    }
    
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        color: white;
        text-align: center;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: #667eea;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }
    
    .profile-body {
        padding: 30px;
    }
    
    .contact-info {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .info-item {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #667eea;
    }
    
    .info-content h5 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #7a7a7a;
    }
    
    .info-content p {
        margin: 0;
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-outline-primary:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        text-decoration: none;
        color: white;
    }
    
    .social-links {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .social-link:hover {
        background: #667eea;
        color: white;
        transform: translateY(-3px);
        text-decoration: none;
    }
</style>

<div class="profile-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 class="fw-bold">{{ $user->name }}</h3>
                        <p class="text-light mb-0">{{ $user->email }}</p>
                    </div>
                    
                    <div class="profile-body">
                        <div class="contact-info">
                            <h4 class="mb-4 text-center">Contact Information</h4>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Email Address</h5>
                                    <p>
                                        <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                            {{ $user->email }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                             
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Address</h5>
                                    <p>{{ $user->address ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="social-links">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-primary flex-grow-1">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                            <a href="#" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-envelope me-2"></i> Message
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection
