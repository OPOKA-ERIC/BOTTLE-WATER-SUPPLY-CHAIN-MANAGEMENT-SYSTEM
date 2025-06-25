@extends('layouts.app', ['activePage' => 'register', 'title' => 'Register - BWSCMS Management System'])

@section('content')
    <div class="full-page register-page section-image" data-color="blue" data-image="{{ asset('light-bootstrap/img/full-screen-image-2.jpg') }}">
        <!-- Overlay for better text readability -->
        <div class="overlay" style="background: linear-gradient(135deg, rgba(25, 118, 210, 0.8) 0%, rgba(13, 71, 161, 0.9) 100%);"></div>
        
        <div class="content position-relative">
            <div class="container">
                <!-- Hero Section -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10 text-center">
                        <!-- Logo/Icon Section -->
                        <div class="mb-4">
                            <div class="hero-icon mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                                <i class="nc-icon nc-drop text-white" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        
                        <h1 class="text-white display-4 mb-4 font-weight-bold" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3); letter-spacing: -1px;">
                            Join Our
                            <span class="d-block text-primary" style="color: #64b5f6 !important;">BWSCMS Network</span>
                        </h1>
                        
                        <p class="text-white lead mb-5" style="font-size: 1.25rem; opacity: 0.9; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                            Create your supply chain management account and start optimizing your operations
                        </p>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="card card-register card-plain text-center" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; backdrop-filter: blur(15px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);">
                            <div class="card-header text-center" style="background: transparent; border: none; padding: 2rem 2rem 1rem;">
                                <h3 class="header text-white font-weight-bold mb-0" style="font-size: 1.5rem; letter-spacing: 0.5px;">{{ __('Create Account') }}</h3>
                                <div class="mt-2" style="width: 40px; height: 3px; background: linear-gradient(45deg, #2196F3, #21CBF3); margin: 0 auto; border-radius: 2px;"></div>
                            </div>
                            
                            <div class="card-body" style="padding: 1rem 2rem 2rem;">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    
                                    <!-- Error Messages -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger mb-4" style="background: rgba(255, 107, 107, 0.1); border: 1px solid rgba(255, 107, 107, 0.3); border-radius: 12px; color: #ff6b6b;">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="nc-icon nc-alert-circle-i mr-2"></i>
                                                <strong>Please fix the following errors:</strong>
                                            </div>
                                            <ul class="mb-0 pl-3">
                                                @foreach ($errors->all() as $error)
                                                    <li style="font-size: 0.9rem;">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Name Field -->
                                    <div class="form-group mb-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none; padding: 16px 20px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; height: 60px; min-height: 60px;">
                                                    <i class="nc-icon nc-single-02 text-white" style="opacity: 0.7; font-size: 1.2rem;"></i>
                                                </span>
                                            </div>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   placeholder="{{ __('Full Name') }}" 
                                                   value="{{ old('name') }}" 
                                                   required 
                                                   autofocus
                                                   style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; padding: 16px 20px; border-radius: 0 10px 10px 0; font-size: 1.1rem; height: 60px; min-height: 60px;">
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block" style="color: #ff6b6b; font-size: 0.85rem; margin-top: 0.5rem;">
                                                <i class="nc-icon nc-alert-circle-i mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Email Field -->
                                    <div class="form-group mb-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none; padding: 16px 20px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; height: 60px; min-height: 60px;">
                                                    <i class="nc-icon nc-email-85 text-white" style="opacity: 0.7; font-size: 1.2rem;"></i>
                                                </span>
                                            </div>
                                            <input type="email" 
                                                   name="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   value="{{ old('email') }}" 
                                                   placeholder="Enter your email address" 
                                                   required
                                                   style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; padding: 16px 20px; border-radius: 0 10px 10px 0; font-size: 1.1rem; height: 60px; min-height: 60px;">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block" style="color: #ff6b6b; font-size: 0.85rem; margin-top: 0.5rem;">
                                                <i class="nc-icon nc-alert-circle-i mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Role Selection -->
                                    <div class="form-group mb-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none; padding: 16px 20px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; height: 60px; min-height: 60px;">
                                                    <i class="nc-icon nc-badge text-white" style="opacity: 0.7; font-size: 1.2rem;"></i>
                                                </span>
                                            </div>
                                            <select name="role" 
                                                    class="form-control custom-select @error('role') is-invalid @enderror" 
                                                    required
                                                    style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; padding: 16px 20px; border-radius: 0 10px 10px 0; font-size: 1.1rem; height: 60px; min-height: 60px;">
                                                <option value="" disabled selected style="background: #1565C0; color: white;">Select your role</option>
                                                <option value="administrator" {{ old('role') == 'administrator' ? 'selected' : '' }} style="background: #1565C0; color: white;">
                                                    👑 Administrator
                                                </option>
                                                <option value="retailer" {{ old('role') == 'retailer' ? 'selected' : '' }} style="background: #1565C0; color: white;">
                                                    🏪 Retailer
                                                </option>
                                                <option value="supplier" {{ old('role') == 'supplier' ? 'selected' : '' }} style="background: #1565C0; color: white;">
                                                    🚛 Supplier
                                                </option>
                                                <option value="manufacturer" {{ old('role') == 'manufacturer' ? 'selected' : '' }} style="background: #1565C0; color: white;">
                                                    🏭 Manufacturer
                                                </option>
                                                <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }} style="background: #1565C0; color: white;">
                                                    🛒 Vendor
                                                </option>
                                            </select>
                                        </div>
                                        @error('role')
                                            <div class="invalid-feedback d-block" style="color: #ff6b6b; font-size: 0.85rem; margin-top: 0.5rem;">
                                                <i class="nc-icon nc-alert-circle-i mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group mb-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none; padding: 16px 20px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; height: 60px; min-height: 60px;">
                                                    <i class="nc-icon nc-key-25 text-white" style="opacity: 0.7; font-size: 1.2rem;"></i>
                                                </span>
                                            </div>
                                            <input type="password" 
                                                   name="password" 
                                                   id="password"
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Create a strong password" 
                                                   required
                                                   style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; padding: 16px 20px; border-radius: 0 10px 10px 0; font-size: 1.1rem; height: 60px; min-height: 60px;">
                                            <div class="input-group-append">
                                                <span class="input-group-text toggle-password" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; cursor: pointer; padding: 16px 20px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; height: 60px; min-height: 60px;">
                                                    <i class="nc-icon nc-zoom-split text-white" style="opacity: 0.7; font-size: 1.2rem;"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block" style="color: #ff6b6b; font-size: 0.85rem; margin-top: 0.5rem;">
                                                <i class="nc-icon nc-alert-circle-i mr-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="form-group mb-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none; padding: 16px 20px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; height: 60px; min-height: 60px;">
                                                    <i class="nc-icon nc-check-2 text-white" style="opacity: 0.7; font-size: 1.2rem;"></i>
                                                </span>
                                            </div>
                                            <input type="password" 
                                                   name="password_confirmation" 
                                                   id="password_confirmation"
                                                   placeholder="Confirm your password" 
                                                   class="form-control" 
                                                   required
                                                   style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; padding: 16px 20px; border-radius: 0 10px 10px 0; font-size: 1.1rem; height: 60px; min-height: 60px;">
                                        </div>
                                        <div class="password-match-indicator mt-2" style="display: none;">
                                            <small class="text-success">
                                                <i class="nc-icon nc-check-2 mr-1"></i>Passwords match
                                            </small>
                                        </div>
                                        <div class="password-mismatch-indicator mt-2" style="display: none;">
                                            <small class="text-danger">
                                                <i class="nc-icon nc-simple-remove mr-1"></i>Passwords don't match
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="form-group mb-4">
                                        <div class="form-check d-flex align-items-start text-left">
                                            <div class="input-group-prepend" style="margin-right: 12px;">
                                                <span class="input-group-text" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; justify-content: center; height: 45px; min-height: 45px;">
                                                    <i class="nc-icon nc-check-2 text-white" style="opacity: 0.7; font-size: 1.1rem;"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-start">
                                            <input class="form-check-input mt-1" 
                                                   name="agree" 
                                                   type="checkbox" 
                                                   id="agree"
                                                   required
                                                       style="transform: scale(1.5); margin-right: 12px; width: 20px; height: 20px; background-color: rgba(255, 255, 255, 0.2); border: 2px solid rgba(255, 255, 255, 0.5); border-radius: 4px; cursor: pointer; appearance: none; -webkit-appearance: none; position: relative;">
                                            <label class="form-check-label text-white mb-0" for="agree" style="opacity: 0.9; font-size: 0.9rem; cursor: pointer; line-height: 1.4;">
                                                I agree to the <a href="#" class="text-decoration-none" style="color: #64b5f6;">Terms and Conditions</a> and <a href="#" class="text-decoration-none" style="color: #64b5f6;">Privacy Policy</a>
                                            </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="footer text-center">
                                        <button type="submit" 
                                                class="btn btn-primary btn-block font-weight-bold"
                                                style="background: linear-gradient(45deg, #2196F3, #21CBF3); border: none; border-radius: 12px; padding: 12px; font-size: 1rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4); transition: all 0.3s ease;">
                                            <i class="nc-icon nc-tap-01 mr-2"></i>{{ __('Create Account') }}
                                        </button>
                                    </div>

                                    <!-- Login Link -->
                                    <div class="text-center mt-3">
                                        <p class="text-white mb-0" style="opacity: 0.8; font-size: 0.9rem;">
                                            Already have an account? 
                                            <a href="{{ route('login') }}" class="text-decoration-none font-weight-bold" style="color: #64b5f6; transition: all 0.3s ease;">
                                                Sign in here
                                            </a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Role Info Cards -->
                        <div class="role-info mt-4">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="mini-feature text-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 1rem; backdrop-filter: blur(5px); transition: all 0.3s ease;">
                                        <i class="nc-icon nc-shop text-white mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                        <p class="text-white small mb-0" style="opacity: 0.7; font-size: 0.8rem;">Retail Management</p>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="mini-feature text-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 1rem; backdrop-filter: blur(5px); transition: all 0.3s ease;">
                                        <i class="nc-icon nc-settings-gear-64 text-white mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                        <p class="text-white small mb-0" style="opacity: 0.7; font-size: 0.8rem;">Supply Chain</p>
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
            50% { transform: translateY(-10px); }
        }
        
        .card-register {
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
        }
        
        .card-register:not(.card-hidden) {
            transform: translateY(0);
            opacity: 1;
        }
        
        .form-control, .custom-select {
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .custom-select:focus {
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
        
        .toggle-password:hover {
            background: rgba(255, 255, 255, 0.15) !important;
        }
        
        .role-info {
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
        
        /* Form validation styles */
        .form-control.is-invalid, .custom-select.is-invalid {
            border-color: #ff6b6b !important;
            background: rgba(255, 107, 107, 0.1) !important;
        }
        
        .form-control.is-invalid:focus, .custom-select.is-invalid:focus {
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
        
        /* Custom checkbox for terms and conditions */
        #agree {
            background-color: #ffffff !important;
            border: 2px solid #ffffff !important;
            border-radius: 4px !important;
            cursor: pointer !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            position: relative !important;
            transition: all 0.3s ease !important;
        }
        
        #agree:checked {
            background-color: #ffffff !important;
            border-color: #2196F3 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%232196F3' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e") !important;
            background-size: 12px 12px !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }
        
        #agree:hover {
            background-color: #ffffff !important;
            border-color: #2196F3 !important;
        }
        
        #agree:focus {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.3) !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .card-register {
                margin: 0 10px;
            }
            
            .card-body {
                padding: 1rem 1.5rem 1.5rem !important;
            }
            
            .display-4 {
                font-size: 2rem !important;
            }
            
            .input-group-text {
                padding: 0.5rem 0.75rem;
            }
        }
        
        /* Link hover effects */
        a:hover {
            color: #90caf9 !important;
            text-decoration: none !important;
        }
        
        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
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
            
            // Password confirmation matching
            function checkPasswordMatch() {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();
                
                if (confirmPassword.length > 0) {
                    if (password === confirmPassword) {
                        $('.password-match-indicator').show();
                        $('.password-mismatch-indicator').hide();
                    } else {
                        $('.password-match-indicator').hide();
                        $('.password-mismatch-indicator').show();
                    }
                } else {
                    $('.password-match-indicator, .password-mismatch-indicator').hide();
                }
            }
            
            $('#password, #password_confirmation').on('input', checkPasswordMatch);
            
            // Form submission with loading state
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                
                submitBtn.html('<i class="nc-icon nc-refresh-69 fa-spin mr-2"></i>Creating Account...');
                submitBtn.prop('disabled', true);
                
                // Reset button if there's an error (remove this timeout in production)
                setTimeout(function() {
                    if (submitBtn.prop('disabled')) {
                        submitBtn.html(originalText);
                        submitBtn.prop('disabled', false);
                    }
                }, 3000);
            });
            
            // Form field navigation
            $('#name').on('keypress', function(e) {
                if (e.which === 13 && $(this).val()) {
                    $('input[name="email"]').focus();
                    e.preventDefault();
                }
            });
            
            $('input[name="email"]').on('keypress', function(e) {
                if (e.which === 13 && $(this).val()) {
                    $('select[name="role"]').focus();
                    e.preventDefault();
                }
            });
            
            // Role selection enhancement
            $('select[name="role"]').on('change', function() {
                if ($(this).val()) {
                    $('#password').focus();
                }
            });
            
            // Form validation feedback
            $('.form-control, .custom-select').on('input change', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').fadeOut();
                }
            });
            
            // Terms checkbox validation
            $('#agree').on('change', function() {
                const submitBtn = $('button[type="submit"]');
                if ($(this).is(':checked')) {
                    submitBtn.prop('disabled', false);
                } else {
                    submitBtn.prop('disabled', true);
                }
            });
            
            // Initial checkbox check
            const agreeCheckbox = $('#agree');
            const submitBtn = $('button[type="submit"]');
            submitBtn.prop('disabled', !agreeCheckbox.is(':checked'));
            
            // Route validation (for debugging)
            console.log('Register Routes:');
            console.log('Register POST: {{ route("register") }}');
            console.log('Login: {{ route("login") }}');
        });
    </script>
@endpush