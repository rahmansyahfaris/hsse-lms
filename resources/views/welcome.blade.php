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
                    EEES Company
                </p>
            </div>

            <!-- Login / Dashboard Actions -->
            <div class="w-full max-w-sm">
                @if (Route::has('login'))
                    <div class="flex flex-col gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full text-center px-6 py-4 bg-indigo-600 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300 transform hover:-translate-y-1">
                                Go to Dashboard
                            </a>
                            <div class="text-center">
                                <span class="text-gray-500 text-sm">You are already logged in.</span>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="w-full text-center px-6 py-4 bg-indigo-600 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300 transform hover:-translate-y-1">
                                Log in
                            </a>
                            
                            <!-- Hidden registration link note (Admin only) -->
                            <div class="mt-8 text-center border-t border-gray-200 dark:border-gray-700 pt-6">
                                <p class="text-gray-400 text-sm">
                                    Don't have an account? <br>
                                    Please contact the <span class="font-semibold text-gray-600 dark:text-gray-300">HSSE Administrator</span>.
                                </p>
                            </div>
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="mt-16 text-center text-sm text-gray-400 dark:text-gray-500">
                &copy; {{ date('Y') }} EEES Company. All rights reserved.
            </div>
            
        </div>
    </body>
</html>
