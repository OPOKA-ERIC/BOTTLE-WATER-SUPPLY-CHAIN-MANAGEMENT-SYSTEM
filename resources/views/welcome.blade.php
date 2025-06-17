@extends('layouts/app', ['activePage' => 'welcome', 'title' => 'Bottle Water Supply Chain Management System'])

@section('content')
    <div class="full-page section-image" data-color="blue" data-image="{{asset('light-bootstrap/img/full-screen-image-2.jpg')}}">
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
                        
                        <h1 class="text-white display-3 mb-4 font-weight-bold" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3); letter-spacing: -1px;">
                            Bottle Water Supply Chain
                            <span class="d-block text-primary" style="color: #64b5f6 !important;">Management System</span>
                        </h1>
                        
                        <p class="text-white lead mb-5" style="font-size: 1.25rem; opacity: 0.9; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                            Streamline your water bottle supply chain with our comprehensive, intelligent management system designed for modern businesses
                        </p>
                        
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mr-3 px-5 py-3" style="background: linear-gradient(45deg, #2196F3, #21CBF3); border: none; border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4); transition: all 0.3s ease;">
                                <i class="nc-icon nc-key-25 mr-2"></i>Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3" style="border: 2px solid rgba(255, 255, 255, 0.8); border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; backdrop-filter: blur(10px); transition: all 0.3s ease;">
                                <i class="nc-icon nc-single-02 mr-2"></i>Register
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-12">
                        <div class="row">
                            <!-- Feature 1 -->
                            <div class="col-md-4 mb-4">
                                <div class="feature-card h-100" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; backdrop-filter: blur(10px); transition: all 0.3s ease; padding: 2rem;">
                                    <div class="text-center">
                                        <div class="feature-icon mb-4 mx-auto" style="width: 70px; height: 70px; background: linear-gradient(45deg, #FF6B6B, #FF8E53); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);">
                                            <i class="nc-icon nc-chart-pie-35 text-white" style="font-size: 2rem;"></i>
                                        </div>
                                        <h4 class="text-white mb-3 font-weight-bold">Real-time Tracking</h4>
                                        <p class="text-white" style="opacity: 0.8; line-height: 1.6;">Monitor your entire supply chain in real-time with our advanced tracking system and live updates</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Feature 2 -->
                            <div class="col-md-4 mb-4">
                                <div class="feature-card h-100" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; backdrop-filter: blur(10px); transition: all 0.3s ease; padding: 2rem;">
                                    <div class="text-center">
                                        <div class="feature-icon mb-4 mx-auto" style="width: 70px; height: 70px; background: linear-gradient(45deg, #4ECDC4, #44A08D); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);">
                                            <i class="nc-icon nc-single-copy-04 text-white" style="font-size: 2rem;"></i>
                                        </div>
                                        <h4 class="text-white mb-3 font-weight-bold">Inventory Management</h4>
                                        <p class="text-white" style="opacity: 0.8; line-height: 1.6;">Efficiently manage your inventory with automated tracking, smart alerts, and predictive analytics</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Feature 3 -->
                            <div class="col-md-4 mb-4">
                                <div class="feature-card h-100" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; backdrop-filter: blur(10px); transition: all 0.3s ease; padding: 2rem;">
                                    <div class="text-center">
                                        <div class="feature-icon mb-4 mx-auto" style="width: 70px; height: 70px; background: linear-gradient(45deg, #A8E6CF, #88D8A3); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(168, 230, 207, 0.3);">
                                            <i class="nc-icon nc-badge text-white" style="font-size: 2rem;"></i>
                                        </div>
                                        <h4 class="text-white mb-3 font-weight-bold">Role-based Access</h4>
                                        <p class="text-white" style="opacity: 0.8; line-height: 1.6;">Secure access control for administrators, suppliers, manufacturers, and retailers with permissions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Features -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="mini-feature text-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; padding: 1.5rem; backdrop-filter: blur(5px); transition: all 0.3s ease;">
                                    <i class="nc-icon nc-delivery-fast text-white mb-3" style="font-size: 2rem; opacity: 0.8;"></i>
                                    <h6 class="text-white font-weight-bold">Order Management</h6>
                                    <p class="text-white small mb-0" style="opacity: 0.7;">Streamline order processing</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="mini-feature text-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; padding: 1.5rem; backdrop-filter: blur(5px); transition: all 0.3s ease;">
                                    <i class="nc-icon nc-chart-bar-32 text-white mb-3" style="font-size: 2rem; opacity: 0.8;"></i>
                                    <h6 class="text-white font-weight-bold">Analytics Dashboard</h6>
                                    <p class="text-white small mb-0" style="opacity: 0.7;">Data-driven decisions</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="mini-feature text-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; padding: 1.5rem; backdrop-filter: blur(5px); transition: all 0.3s ease;">
                                    <i class="nc-icon nc-notification-70 text-white mb-3" style="font-size: 2rem; opacity: 0.8;"></i>
                                    <h6 class="text-white font-weight-bold">Smart Alerts</h6>
                                    <p class="text-white small mb-0" style="opacity: 0.7;">Proactive notifications</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="mini-feature text-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; padding: 1.5rem; backdrop-filter: blur(5px); transition: all 0.3s ease;">
                                    <i class="nc-icon nc-settings-gear-64 text-white mb-3" style="font-size: 2rem; opacity: 0.8;"></i>
                                    <h6 class="text-white font-weight-bold">Automation</h6>
                                    <p class="text-white small mb-0" style="opacity: 0.7;">Workflow optimization</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-8">
                        <div class="stats-container" style="background: rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 2rem; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h3 class="text-white font-weight-bold mb-1" style="font-size: 2.5rem;">500+</h3>
                                    <p class="text-white small mb-0" style="opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">Companies Trust Us</p>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="text-white font-weight-bold mb-1" style="font-size: 2.5rem;">99.9%</h3>
                                    <p class="text-white small mb-0" style="opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">Uptime Guarantee</p>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="text-white font-weight-bold mb-1" style="font-size: 2.5rem;">24/7</h3>
                                    <p class="text-white small mb-0" style="opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">Support Available</p>
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
        
        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .mini-feature:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1) !important;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.6) !important;
        }
        
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .hero-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .display-3 {
                font-size: 2.5rem !important;
            }
            
            .btn-lg {
                padding: 0.75rem 2rem !important;
                font-size: 1rem !important;
            }
            
            .feature-card {
                margin-bottom: 2rem;
            }
        }
        
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
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
            
            // Add smooth scrolling and animation effects
            $('[data-toggle="tooltip"]').tooltip();
            
            // Add loading animation for buttons
            $('.btn').on('click', function() {
                var $btn = $(this);
                var originalText = $btn.html();
                
                $btn.html('<i class="nc-icon nc-refresh-69 fa-spin mr-2"></i>Loading...');
                
                // Reset button after a short delay (remove this in production)
                setTimeout(function() {
                    $btn.html(originalText);
                }, 1000);
            });
            
            // Add intersection observer for animations
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                });
                
                // Observe feature cards
                document.querySelectorAll('.feature-card, .mini-feature').forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    observer.observe(card);
                });
            }
        });
        
        // Route validation (optional - for debugging)
        console.log('Routes configured:');
        console.log('Login route: {{ route("login") }}');
        console.log('Register route: {{ route("register") }}');
    </script>
@endpush