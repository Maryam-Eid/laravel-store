<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        @foreach($items as $item)
            <li class="nav-item">
                <a href="{{ route($item['route']) }}" class="nav-link {{ Route::is($item['active'])? 'active' : '' }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <p>
                        {{ $item['title'] }}
                        @if(isset($item['badge']))
                        <i class="right badge badge-light">{{ $item['badge'] }}</i>
                        @endif
                    </p>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
