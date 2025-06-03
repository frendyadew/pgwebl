<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark"> {{-- Ganti bg-body-tertiary menjadi bg-dark dan tambahkan data-bs-theme="dark" --}}
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}"> {{-- Arahkan ke home/root URL --}}
            <i class="fa-solid fa-earth-americas"></i> {{ $title }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}"><i class="fa-solid fa-house"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('map') }}"><i class="fa-solid fa-map-location-dot"></i> Map</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'table' ? 'active' : '' }}" href="{{ route('table') }}"><i class="fa-solid fa-table-list"></i> Table</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ in_array(Route::currentRouteName(), ['api.points', 'api.polylines', 'api.polygons']) ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="fa-solid fa-database"></i> Data
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                       <li>
                          <a class="dropdown-item {{ Route::currentRouteName() == 'api.points' ? 'active' : '' }}" href="{{ route('api.points') }}"><i class="fa-solid fa-map-pin"></i> Points</a>
                       </li>
                       <li>
                          <a class="dropdown-item {{ Route::currentRouteName() == 'api.polylines' ? 'active' : '' }}" href="{{ route('api.polylines') }}"><i class="fa-solid fa-route"></i> Polylines</a>
                       </li>
                       <li>
                          <a class="dropdown-item {{ Route::currentRouteName() == 'api.polygons' ? 'active' : '' }}" href="{{ route('api.polygons') }}"><i class="fa-solid fa-shapes"></i> Polygons</a>
                       </li>
                    </ul>
                </li>
                @endauth
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </form>
                </li>
                @endauth
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i> Register</a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

