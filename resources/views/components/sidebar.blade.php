<aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 min-h-screen">
    <!--
    <div class="h-16 flex flex-col items-center justify-center border-b border-gray-100 dark:border-gray-700">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">HSSE LMS</h1>
        <p class="text-xs text-gray-500">EEES</p>
    </div>
    -->
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
            
            @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <span class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</span>
                    <a href="{{ route('admin.users.index') }}"
                       class="mt-2 block px-4 py-2 rounded-lg transition-colors duration-200
                              {{ request()->routeIs('admin.users.*') 
                                 ? 'bg-red-50 text-red-600 dark:text-red-400' 
                                 : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' 
                              }}">
                        Manage Users
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</aside>


