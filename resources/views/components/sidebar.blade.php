<aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 min-h-screen">
    <div class="h-16 flex items-center justify-center border-b border-gray-100 dark:border-gray-700">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">HSSE LMS</h1>
    </div>
    <nav class="p-4">
        @php $menu = config('menu'); @endphp
        <ul class="space-y-2">
            @foreach ($menu as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="block px-4 py-2 rounded-lg transition-colors duration-200
                              {{ request()->routeIs($item['route']) 
                                 ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300' 
                                 : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' 
                              }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>


