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
                    {{-- Tentukan link aktif berdasarkan halaman saat ini jika perlu --}}
                    {{-- Contoh sederhana: jika route saat ini adalah 'home' (jika ada), tambahkan 'active' --}}
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                     {{-- Contoh sederhana: jika route saat ini adalah 'map', tambahkan 'active' --}}
                    <a class="nav-link {{ Route::currentRouteName() == 'map' ? 'active' : '' }}" href="{{ route('map') }}">Map</a>
                </li>
                <li class="nav-item">
                     {{-- Contoh sederhana: jika route saat ini adalah 'table', tambahkan 'active' --}}
                    <a class="nav-link {{ Route::currentRouteName() == 'table' ? 'active' : '' }}" href="{{ route('table') }}">Table</a>
                </li>
                {{-- HAPUS Dropdown --}}
                {{-- HAPUS Link Disabled --}}
            </ul>
            {{-- HAPUS Form Search --}}
        </div>
    </div>
</nav>
