<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Zizz Shop') }}</title>

        <link rel="icon" href="https://files.catbox.moe/5z7z6d.png">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('scripts')

        <style>
            /* Enhanced styles for dark theme with cyan, purple, and blue colors */
            body {
                font-family: 'Inter', sans-serif;
                overflow-x: hidden;
            }

            /* Text gradient effects */
            .text-gradient {
                background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
                -webkit-background-clip: text; 
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .text-gradient-purple {
                background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
                -webkit-background-clip: text; 
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Enhanced background with multiple gradient layers */
            .page-background-glow {
                position: relative;
                background: #0f172a;
                background-image:
                    radial-gradient(ellipse 80% 80% at 20% -20%, rgba(6, 182, 212, 0.1), transparent),
                    radial-gradient(ellipse 80% 80% at 80% -20%, rgba(139, 92, 246, 0.1), transparent),
                    radial-gradient(ellipse 80% 80% at 40% 120%, rgba(59, 130, 246, 0.1), transparent),
                    radial-gradient(ellipse 60% 60% at 90% 50%, rgba(147, 51, 234, 0.08), transparent),
                    radial-gradient(ellipse 60% 60% at 10% 80%, rgba(6, 182, 212, 0.08), transparent);
            }

            .page-background-glow::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: 
                    linear-gradient(45deg, transparent 30%, rgba(6, 182, 212, 0.02) 50%, transparent 70%),
                    linear-gradient(-45deg, transparent 30%, rgba(139, 92, 246, 0.02) 50%, transparent 70%);
                pointer-events: none;
            }

            /* Enhanced glass morphism effect */
            .glass-effect {
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(6, 182, 212, 0.2);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .glass-morphism {
                background: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(6, 182, 212, 0.15);
            }

            /* Animated gradient borders */
            .animated-border {
                position: relative;
                overflow: hidden;
            }

            .animated-border::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(6, 182, 212, 0.4), transparent);
                animation: shimmer 3s infinite;
            }

            @keyframes shimmer {
                0% { left: -100%; }
                100% { left: 100%; }
            }

            /* Floating animation */
            .floating {
                animation: floating 6s ease-in-out infinite;
            }

            @keyframes floating {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            /* Glow effects */
            .glow-cyan {
                box-shadow: 0 4px 20px rgba(6, 182, 212, 0.3);
            }

            .glow-purple {
                box-shadow: 0 4px 20px rgba(139, 92, 246, 0.3);
            }

            .glow-blue {
                box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
            }

            /* Scroll bar styling */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(15, 23, 42, 0.8);
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg, #06b6d4, #8b5cf6);
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #0891b2, #7c3aed);
            }

            /* Enhanced header gradient line */
            .header-gradient-line {
                background: linear-gradient(90deg, #06b6d4, #3b82f6, #8b5cf6, #ec4899);
                background-size: 200% 100%;
                animation: gradientShift 3s ease infinite;
            }

            @keyframes gradientShift {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }

            /* Card hover effects */
            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.4),
                    0 0 20px rgba(6, 182, 212, 0.2);
            }

            /* Particle effect background */
            .particles {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 1;
            }

            .particle {
                position: absolute;
                width: 2px;
                height: 2px;
                background: rgba(6, 182, 212, 0.6);
                border-radius: 50%;
                animation: particle-float 8s infinite linear;
            }

            .particle:nth-child(odd) {
                background: rgba(139, 92, 246, 0.6);
                animation-duration: 10s;
            }

            @keyframes particle-float {
                0% {
                    transform: translateY(100vh) translateX(0);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                90% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100px) translateX(100px);
                    opacity: 0;
                }
            }

            /* Button styles */
            .btn-primary {
                background: linear-gradient(135deg, #06b6d4, #3b82f6);
                border: 1px solid rgba(6, 182, 212, 0.3);
                color: white;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #0891b2, #2563eb);
                box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4);
                transform: translateY(-2px);
            }

            .btn-secondary {
                background: linear-gradient(135deg, #8b5cf6, #ec4899);
                border: 1px solid rgba(139, 92, 246, 0.3);
                color: white;
                transition: all 0.3s ease;
            }

            .btn-secondary:hover {
                background: linear-gradient(135deg, #7c3aed, #db2777);
                box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body class="font-sans text-gray-100 antialiased bg-gray-900 page-background-glow">
        <!-- Animated particles background -->
        <div class="particles">
            <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
            <div class="particle" style="left: 20%; animation-delay: 2s;"></div>
            <div class="particle" style="left: 30%; animation-delay: 4s;"></div>
            <div class="particle" style="left: 40%; animation-delay: 1s;"></div>
            <div class="particle" style="left: 50%; animation-delay: 3s;"></div>
            <div class="particle" style="left: 60%; animation-delay: 5s;"></div>
            <div class="particle" style="left: 70%; animation-delay: 2.5s;"></div>
            <div class="particle" style="left: 80%; animation-delay: 4.5s;"></div>
            <div class="particle" style="left: 90%; animation-delay: 1.5s;"></div>
        </div>

        <div class="min-h-screen relative z-10">
            @include('layouts.navigation')

            <!-- Enhanced Page Heading -->
            @isset($header)
                <header class="glass-effect shadow-2xl border-b border-cyan-500/20 relative overflow-hidden">
                    <!-- Background decoration -->
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/5 via-blue-500/5 to-purple-500/5"></div>
                    
                    <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <!-- Animated gradient line -->
                        <div class="header-gradient-line w-32 h-1 rounded-full mb-6"></div>
                        
                        <!-- Header content with enhanced styling -->
                        <div class="relative">
                            {{ $header }}
                        </div>
                        
                        <!-- Decorative elements -->
                        <div class="absolute top-4 right-4 opacity-20">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 blur-xl"></div>
                        </div>
                        <div class="absolute bottom-4 left-4 opacity-20">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-400 to-cyan-600 blur-lg"></div>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Enhanced Page Content -->
            <main class="relative z-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Content wrapper with subtle effects -->
                    <div class="relative">
                        {{ $slot }}
                    </div>
                </div>
            </main>

            @include('layouts.footer')
        </div>

        <!-- Additional JavaScript for enhanced interactions -->
        <script>
            // Add floating animation to cards on scroll
            window.addEventListener('scroll', () => {
                const cards = document.querySelectorAll('.card-hover');
                cards.forEach(card => {
                    const rect = card.getBoundingClientRect();
                    const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                    
                    if (isVisible) {
                        card.style.transform = `translateY(${window.scrollY * 0.02}px)`;
                    }
                });
            });

            // Add particle animation randomization
            document.addEventListener('DOMContentLoaded', () => {
                const particles = document.querySelectorAll('.particle');
                particles.forEach((particle, index) => {
                    const randomDelay = Math.random() * 8;
                    const randomDuration = 8 + Math.random() * 4;
                    particle.style.animationDelay = `${randomDelay}s`;
                    particle.style.animationDuration = `${randomDuration}s`;
                    particle.style.left = `${Math.random() * 100}%`;
                });
            });
        </script>
    </body>
</html>