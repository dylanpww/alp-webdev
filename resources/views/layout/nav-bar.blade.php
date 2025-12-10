<nav class="navbar navbar-expand-lg navbar-dark shadow-sm " style="background:  #f3f3ea">
    <div class="container py-1">
        <a class="navbar-brand fw-bold text-black fs-4" href="/">
            <img src="{{ asset('logo_sarang.png') }}" alt="Sarang Logo" class="img-fluid"
                style="height: 70px; width: auto;">
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
                        Book Room
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link {{ Request::is('rent-motorcycle') ? 'active' : '' }}" href="/rent-motorcycle">
                        Rent a Motorcycle!
                    </a>
                </li>


                <li class="nav-item dropdown mx-2">
                    @auth
                        @if (Auth::user()->role === 'manager')
                            <a class="nav-link dropdown-toggle {{ Request::is('manager/*') ? 'active': '' }}"
                        href="#" id="managerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manager Dashboard
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="managerDropdown">

                <li>
                    <a class="dropdown-item {{ Request::is('manager/type*') ? 'active' : '' }}" 
                    href="/admin_view/type">Type</a>
                </li>

                <li>
                    <a class="dropdown-item {{ Request::is('manager/room*') ? 'active' : '' }}" 
                    href="/admin_view/room">Room</a>
                </li>

                <li>
                    <a class="dropdown-item {{ Request::is('manager/rents*') ? 'active' : '' }}" 
                    href="/admin_view/rents">Rents</a>
                </li>

                <li>
                    <a class="dropdown-item {{ Request::is('manager/facility*') ? 'active' : '' }}" 
                    href="/admin_view/facility">Facility</a>
                </li>

            </ul>
                        @endif
                    @endauth
                </li>



                <li class="nav-item dropdown mx-2">
                    @auth
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    My Profile & Bookings
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    @endauth

                    @guest
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="/login">Login</a>
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