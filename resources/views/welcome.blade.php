<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)
      }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} - Scaffold Boilerplate</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            .animate-fade-in { animation: fade-in 0.5s ease-in-out; }
            .animate-fade-in-up { animation: fade-in-up 0.6s ease-out; }
            .animate-fade-in-down { animation: fade-in-down 0.6s ease-out; }
            .animate-slide-in-left { animation: slide-in-left 0.5s ease-out; }
            .animate-slide-in-right { animation: slide-in-right 0.5s ease-out; }
            .animate-scale-in { animation: scale-in 0.3s ease-out; }
            .animate-float { animation: float 3s ease-in-out infinite; }
            .animate-pulse-slow { animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        </style>
    </head>
    <body class="antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
        <!-- Navigation -->
        <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-all duration-300 animate-fade-in-down">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-3 animate-slide-in-left">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center shadow-lg animate-float">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ config('app.name', 'Laravel') }}
                            </h1>
                            <span class="text-xs text-orange-600 dark:text-orange-400 font-medium">
                                Scaffold Boilerplate
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 animate-slide-in-right">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 transform hover:scale-110">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>

                        @auth
                            <a href="{{ url('/admin') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ url('/admin/login') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-600 to-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-orange-700 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>


        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <!-- Animated Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/10 via-red-500/10 to-pink-500/10 dark:from-orange-500/5 dark:via-red-500/5 dark:to-pink-500/5 animate-pulse-slow"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
                <div class="text-center">
                    <!-- Floating Icon -->
                    <div class="mb-8 flex justify-center animate-fade-in">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-red-600 rounded-full blur-2xl opacity-30 animate-pulse-slow"></div>
                            <div class="relative w-20 h-20 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-6 hover:rotate-0 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">
                        Laravel + Filament
                        <span class="block mt-2 bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 dark:from-orange-500 dark:via-red-500 dark:to-pink-500 bg-clip-text text-transparent animate-fade-in-up animation-delay-200">
                            Admin Scaffold
                        </span>
                    </h1>

                    <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed animate-fade-in-up animation-delay-400">
                        A production-ready admin panel boilerplate with advanced user management,
                        role-based access control, and comprehensive activity logging.
                    </p>

                    @auth
                        <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up animation-delay-600">
                            <a href="{{ url('/admin') }}" class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-orange-700 hover:to-red-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                Go to Dashboard
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up animation-delay-600">
                            <a href="{{ url('/admin/login') }}" class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-orange-700 hover:to-red-700 transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                Get Started
                            </a>
                            <a href="#features" class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-xl font-semibold text-sm text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                Learn More
                            </a>
                        </div>
                    @endauth

                    <!-- Metrics -->
                    <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto animate-fade-in animation-delay-800">
                        <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">4</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">Default Roles</div>
                        </div>
                        <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="text-3xl font-bold text-red-600 dark:text-red-400">100%</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">Secure</div>
                        </div>
                        <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="text-3xl font-bold text-pink-600 dark:text-pink-400">24/7</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">Logging</div>
                        </div>
                        <div class="p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">v4</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 font-medium">Filament</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <!-- Features Section -->
        <div class="py-16 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Features Included
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Everything you need to build a secure admin panel
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            User Management
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Complete CRUD operations for users with simple, modal-based interface powered by Filament.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Role-Based Access Control
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Built-in roles and permissions using Spatie Laravel Permission with hierarchical access.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Activity Logging
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Comprehensive activity tracking using Spatie Activity Log with automatic JSON archival system.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Login Attempt Tracking
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Track all authentication attempts (success, failed, logout) with IP addresses and user agents.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Secure by Default
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Superadmin protection, policy-based authorization, and event-driven security architecture.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Clean Architecture
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Well-organized codebase following Laravel best practices with comprehensive documentation.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tech Stack Section -->
        <div class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Built With Modern Stack
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Powered by industry-leading technologies
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                            <div class="text-4xl font-bold text-red-600 mb-2">Laravel</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">v12.x</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                            <div class="text-4xl font-bold text-orange-500 mb-2">Filament</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">v4.x</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                            <div class="text-4xl font-bold text-blue-600 mb-2">Tailwind</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">CSS v4</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                            <div class="text-4xl font-bold text-purple-600 mb-2">Livewire</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">v3.x</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pre-configured Features -->
        <div class="py-16 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Pre-configured & Ready to Use
                    </h2>
                </div>

                <div class="max-w-3xl mx-auto">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">4 Default Roles</h4>
                                <p class="text-gray-600 dark:text-gray-300">Superadmin, Admin, Manager, and User with pre-defined permissions</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Database Seeders</h4>
                                <p class="text-gray-600 dark:text-gray-300">Pre-configured seeders for roles and superadmin account (superadmin@superadmin.com)</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Event Listeners</h4>
                                <p class="text-gray-600 dark:text-gray-300">Automatic logging of login, logout, and failed authentication attempts</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Scheduled Archival</h4>
                                <p class="text-gray-600 dark:text-gray-300">Monthly automatic archival of logs to JSON files for compliance</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Simple Resources</h4>
                                <p class="text-gray-600 dark:text-gray-300">Modal-based CRUD forms for better UX without page navigation</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">PostgreSQL Ready</h4>
                                <p class="text-gray-600 dark:text-gray-300">Optimized for PostgreSQL with proper constraints and enum handling</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="py-16 bg-gradient-to-r from-orange-600 to-red-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Ready to Get Started?
                </h2>
                <p class="text-xl text-orange-100 mb-8">
                    Jump into the admin panel and start building your application
                </p>

                @auth
                    <a href="{{ url('/admin') }}" class="inline-flex items-center px-8 py-4 bg-white border border-transparent rounded-lg font-semibold text-sm text-orange-600 uppercase tracking-widest hover:bg-gray-100 transition shadow-lg">
                        Go to Admin Panel
                    </a>
                @else
                    <a href="{{ url('/admin/login') }}" class="inline-flex items-center px-8 py-4 bg-white border border-transparent rounded-lg font-semibold text-sm text-orange-600 uppercase tracking-widest hover:bg-gray-100 transition shadow-lg">
                        Login to Admin Panel
                    </a>
                @endauth
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center text-gray-600 dark:text-gray-300">
                    <p class="mb-2">
                        Built with ❤️ using Laravel {{ app()->version() }} & Filament 4.x
                    </p>
                    <p class="text-sm">
                        Scaffold Boilerplate &copy; {{ date('Y') }} - Production Ready Admin Panel
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>
