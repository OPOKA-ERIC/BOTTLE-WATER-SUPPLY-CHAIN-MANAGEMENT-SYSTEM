@extends('layouts/app', ['activePage' => 'login', 'title' => 'Login - Bottle Water Supply Chain Management'])

@section('content')
    <div class="full-page section-image" data-color="black" data-image="{{ asset('light-bootstrap/img/full-screen-image-2.jpg') }}">
        <!-- Consistent overlay from welcome page -->
        <div class="overlay" style="background: linear-gradient(135deg, rgba(25, 118, 210, 0.8) 0%, rgba(13, 71, 161, 0.9) 100%);"></div>
        
        <div class="content pt-5 position-relative">
            <div class="container mt-5">
                <!-- Brand Header -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-6 text-center">
                        <div class="brand-header mb-4">
                            <div class="hero-icon mx-auto mb-3" style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                                <i class="nc-icon nc-drop text-white" style="font-size: 1.8rem;"></i>
                            </div>
                            <h2 class="text-white font-weight-bold mb-2" style="letter-spacing: -0.5px;">Welcome Back</h2>
                            <p class="text-white" style="opacity: 0.9;">Sign in to your supply chain dashboard</p>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-md-5 col-lg-4">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="card card-login card-hidden" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; backdrop-filter: blur(15px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);">
                                <div class="card-header text-center" style="background: transparent; border: none; padding: 2rem 2rem 1rem;">
                                    <h3 class="header text-white font-weight-bold mb-0" style="font-size: 1.5rem; letter-spacing: 0.5px;">{{ __('Login') }}</h3>
                                    <div class="mt-2" style="width: 40px; height: 3px; background: linear-gradient(45deg, #2196F3, #21CBF3); margin: 0 auto; border-radius: 2px;"></div>
                                </div>
                                
                                <div class="card-body" style="padding: 1rem 2rem 2rem;">
                                    <!-- Email Field -->
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label text-white font-weight-600 mb-2" style="font-size: 0.9rem; opacity: 0.9;">{{ __('E-Mail Address') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none;">
                                                    <i class="nc-icon nc-email-85 text-white" style="opacity: 0.7;"></i>
                                                </span>
                                            </div>
                                            <input id="email" 
                                                   type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   name="email" 
                                                   value="{{ old('email', 'admin@lightbp.com') }}" 
                                                   required 
                                                   autocomplete="email" 
                                                   autofocus
                                                   placeholder="Enter your email"
                                                   style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; padding: 12px 15px; border-radius: 0 10px 10px 0;">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block" style="color: #ff6b6b; font-size: 0.85rem; margin-top: 0.5rem;">
                                                <i class="nc-icon nc-alert-circle-i mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group mb-4">
                                        <label for="password" class="form-label text-white font-weight-600 mb-2" style="font-size: 0.9rem; opacity: 0.9;">{{ __('Password') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none;">
                                                    <i class="nc-icon nc-key-25 text-white" style="opacity: 0.7;"></i>
                                                </span>
                                            </div>
                                            <input id="password" 
                                                   type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   name="password" 
                                                   value="{{ old('password', 'secret') }}" 
                                                   required 
                                                   autocomplete="current-password"
                                                   placeholder="Enter your password"
                                                   style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; padding: 12px 15px; border-radius: 0 10px 10px 0;">
                                            <div class="input-group-append">
                                                <span class="input-group-text toggle-password" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; cursor: pointer;">
                                                    <i class="nc-icon nc-zoom-split text-white" style="opacity: 0.7;"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block" style="color: #ff6b6b; font-size: 0.85rem; margin-top: 0.5rem;">
                                                <i class="nc-icon nc-alert-circle-i mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="form-group mb-4">
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="remember" 
                                                   id="remember"
                                                   style="margin-right: 10px; transform: scale(1.2);">
                                            <label class="form-check-label text-white mb-0" for="remember" style="opacity: 0.9; font-size: 0.9rem; cursor: pointer;">
                                                {{ __('Remember me') }}
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Login Button -->
                                    <div class="form-group mb-4">
                                        <button type="submit" 
                                                class="btn btn-primary btn-block font-weight-bold"
                                                style="background: linear-gradient(45deg, #2196F3, #21CBF3); border: none; border-radius: 12px; padding: 12px; font-size: 1rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4); transition: all 0.3s ease;">
                                            <i class="nc-icon nc-tap-01 mr-2"></i>{{ __('Login') }}
                                        </button>
                                    </div>

                                    <!-- Action Links -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a class="btn btn-link p-0 text-decoration-none" 
                                           href="{{ route('password.request') }}"
                                           style="color: #64b5f6; font-size: 0.9rem; transition: all 0.3s ease;">
                                            <i class="nc-icon nc-refresh-69 mr-1" style="font-size: 0.8rem;"></i>
                                            {{ __('Forgot password?') }}
                                        </a>
                                        <a class="btn btn-link p-0 text-decoration-none" 
                                           href="{{ route('register') }}"
                                           style="color: #64b5f6; font-size: 0.9rem; transition: all 0.3s ease;">
                                            <i class="nc-icon nc-single-02 mr-1" style="font-size: 0.8rem;"></i>
                                            {{ __('Create account') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Additional Info -->
                        <div class="text-center mt-4">
                            <div class="login-features" style="background: rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 1.5rem; backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.1);">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <i class="nc-icon nc-lock-circle-open text-white mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                        <p class="text-white small mb-0" style="opacity: 0.7; font-size: 0.8rem;">Secure</p>
                                    </div>
                                    <div class="col-4">
                                        <i class="nc-icon nc-spaceship text-white mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                        <p class="text-white small mb-0" style="opacity: 0.7; font-size: 0.8rem;">Fast</p>
                                    </div>
                                    <div class="col-4">
                                        <i class="nc-icon nc-support-17 text-white mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                        <p class="text-white small mb-0" style="opacity: 0.7; font-size: 0.8rem;">Support</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .full-page {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }
        
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .content {
            z-index: 2;
        }
        
        .hero-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        .card-login {
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
        }
        
        .card-login:not(.card-hidden) {
            transform: translateY(0);
            opacity: 1;
        }
        
        .form-control {
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(100, 181, 246, 0.5) !important;
            box-shadow: 0 0 0 0.2rem rgba(100, 181, 246, 0.25) !important;
            color: white !important;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        
        .input-group-text {
            transition: all 0.3s ease;
        }
        
        .form-control:focus + .input-group-append .input-group-text,
        .input-group-prepend .input-group-text:has(+ .form-control:focus) {
            border-color: rgba(100, 181, 246, 0.5) !important;
            background: rgba(255, 255, 255, 0.15) !important;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.6) !important;
        }
        
        .btn-link:hover {
            color: #90caf9 !important;
            text-decoration: none !important;
            transform: translateX(3px);
        }
        
        .toggle-password:hover {
            background: rgba(255, 255, 255, 0.15) !important;
        }
        
        .login-features {
            animation: slideInUp 0.6s ease-out 0.5s both;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .card-login {
                margin: 0 10px;
            }
            
            .card-body {
                padding: 1rem 1.5rem 1.5rem !important;
            }
            
            .brand-header h2 {
                font-size: 1.5rem !important;
            }
        }
        
        /* Form validation styles */
        .form-control.is-invalid {
            border-color: #ff6b6b !important;
            background: rgba(255, 107, 107, 0.1) !important;
        }
        
        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25) !important;
        }
        
        /* Custom checkbox styling */
        .form-check-input:checked {
            background-color: #2196F3;
            border-color: #2196F3;
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Check if the demo object and method exist before calling
            if (typeof demo !== 'undefined' && typeof demo.checkFullPageBackgroundImage === 'function') {
                demo.checkFullPageBackgroundImage();
            }

            // Card animation
            setTimeout(function() {
                $('.card').removeClass('card-hidden');
            }, 300);
            
            // Password toggle functionality
            $('.toggle-password').on('click', function() {
                const passwordField = $('#password');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('nc-zoom-split').addClass('nc-satisfied');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('nc-satisfied').addClass('nc-zoom-split');
                }
            });
            
            // Form submission with loading state
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                
                submitBtn.html('<i class="nc-icon nc-refresh-69 fa-spin mr-2"></i>Signing in...');
                submitBtn.prop('disabled', true);
                
                // Reset button if there's an error (remove this timeout in production)
                setTimeout(function() {
                    if (submitBtn.prop('disabled')) {
                        submitBtn.html(originalText);
                        submitBtn.prop('disabled', false);
                    }
                }, 3000);
            });
            
            // Auto-focus management
            $('#email').on('blur', function() {
                if ($(this).val() && !$('#password').val()) {
                    $('#password').focus();
                }
            });
            
            // Enter key navigation
            $('#email').on('keypress', function(e) {
                if (e.which === 13 && $(this).val()) {
                    $('#password').focus();
                    e.preventDefault();
                }
            });
            
            // Form validation feedback
            $('.form-control').on('input', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').fadeOut();
                }
            });
            
            // Route validation (for debugging)
            console.log('Login Routes:');
            console.log('Login POST: {{ route("login") }}');
            console.log('Password Reset: {{ route("password.request") }}');
            console.log('Register: {{ route("register") }}');
        });
    </script>
@endpush