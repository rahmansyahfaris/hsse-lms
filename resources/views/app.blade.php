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
        <aside class="sidebar">
            <nav>
                <ul>
                    <li>
                        <a href="{{ url('/') }}"
                           class="{{ request()->is('/') ? 'active' : '' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/videos') }}"
                           class="{{ request()->is('videos') ? 'active' : '' }}">
                            Videos
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/photos') }}"
                           class="{{ request()->is('photos') ? 'active' : '' }}">
                            Photos
                        </a>
                    </li>
                    {{-- Add more items later (e.g., Account, Settings) --}}
                </ul>
            </nav>
        </aside>

        {{-- ----------  Main Content  ---------- --}}
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>

