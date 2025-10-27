{{-- resources/views/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LMS Safety' }}</title>

    {{-- Link to the stylesheet you’ll create in step 2 --}}
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="layout">
        {{-- ----------  Sidebar  ---------- --}}
        @include('components.sidebar')

        {{-- ----------  Main Content  ---------- --}}
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>

