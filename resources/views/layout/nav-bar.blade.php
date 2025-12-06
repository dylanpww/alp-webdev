<nav class="navbar navbar-expand-lg navbar-dark shadow-sm " style="background:  #f3f3ea">
    <div class="container py-1">
        <a class="navbar-brand fw-bold text-black fs-4" href="/">
            <img src="logo_sarang.png" alt="Logo" class="img-fluid" style="height: 70px; width: auto;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-black fw-semibold position-relative">
                <li class="nav-item mx-2">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                        Home
                    </a>
                </li>
                <li class="nav-item mx-2 ">
                    <a class="nav-link {{ Request::is('book-now') ? 'active' : '' }}" href="/book-now">
                        Book Now
                    </a>
                </li>
                {{-- <li class="nav-item mx-2">
                    <a class="nav-link {{ Request::is('aboutUs') ? 'active' : '' }}" href="/aboutUs">
                        About Us
                    </a>
                </li> --}}
                {{-- <li class="nav-item mx-2">
                    <a class="nav-link {{ Request::is('cart') ? 'active' : '' }}" href="/cart">
                        View Cart
                    </a>
                </li> --}}

                <li class="nav-item mx-2">
                    @auth
                        @if (Auth::user()->status === 'admin')
                            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="/admin">Admin</a>
                        @endif
                    @endauth
                </li>



                <li class="nav-item mx-2">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn">Log Out</button>
                        </form>
                    @endauth
                    @guest
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="/login">
                            Login
                        </a>
                    @endguest

                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-link {
        color: #000 !important;
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #6c757d !important;
        transform: translateY(-2px);
    }

    .navbar-brand {
        transition: transform 0.3s;
    }

    .navbar-brand:hover {
        transform: scale(1.05);
    }
</style>