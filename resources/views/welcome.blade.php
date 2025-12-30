<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'HSSE LMS') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <!-- Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <style>
            body { font-family: 'Instrument Sans', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col items-center justify-center selection:bg-indigo-500 selection:text-white">
        <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full flex flex-col items-center">
            
            <!-- Company Logo / Branding -->
            <div class="mb-12 text-center">
                <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-2">
                    <span class="text-indigo-600">HSSE</span> LMS
                </h1>
                <p class="text-2xl text-gray-500 dark:text-gray-400 tracking-wider uppercase font-medium">
                    EEES
                </p>
            </div>

            <!-- Login / Dashboard Actions -->
            <div class="w-full max-w-sm">
                @if (Route::has('login'))
                    <div class="flex flex-col gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" style="display: block; width: 100%; text-align: center; padding: 1rem 1.5rem; background-color: #4f46e5; color: white !important; font-size: 1.125rem; font-weight: 600; border-radius: 0.5rem; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                                Go to Dashboard
                            </a>
                            <div style="text-align: center; margin-top: 0.5rem;">
                                <span style="color: #6b7280; font-size: 0.875rem;">You are already logged in.</span>
                            </div>
                        @else
                            <a href="{{ route('login') }}" style="display: block; width: 100%; text-align: center; padding: 1rem 1.5rem; background-color: #4f46e5; color: white !important; visibility: visible !important; opacity: 1 !important; font-size: 1.125rem; font-weight: 600; border-radius: 0.5rem; text-decoration: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                                Log in
                            </a>
                            
                            <!-- Hidden registration link note (Admin only) -->
                            <div style="margin-top: 2rem; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                                <p style="color: #9ca3af; font-size: 0.875rem;">
                                    Don't have an account? <br>
                                    Please contact the <span style="font-weight: 600; color: #4b5563;">HSSE Administrator</span>.
                                </p>
                            </div>
                        @endauth
                    </div>
                @endif
            </div>
            
        </div>
    </body>
</html>
