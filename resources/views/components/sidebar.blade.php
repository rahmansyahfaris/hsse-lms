<aside class="sidebar">
    <nav>
        @php $menu = config('menu'); @endphp
        <ul>
            @foreach ($menu as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>


