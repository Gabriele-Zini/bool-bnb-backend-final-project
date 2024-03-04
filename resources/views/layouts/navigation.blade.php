<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom py-3 ms_office-header">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="logo-back me-4">
            <img src="{{ URL::asset('/img/b.png') }}">
        </div>

        <!-- Hamburger Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link"

                        href="{{ url('http://localhost:5173/') }}">
                        <i class="fa-solid fa-house me-1 nav-item"></i>
                        HomePage
                    </a>
                </li>
                <li class="nav-item">

                    <a class="nav-link{{ request()->routeIs('apartments.index') ? ' ms_active' : '' }}"
                        href="{{ route('apartments.index') }}">
                        <i class="fa-solid fa-building me-1 position-relative"><span
                                class="{{ request()->routeIs('apartments.index') ? ' ms_dot ' : '' }}">

                            </span></i>
                        Apartments</a>


                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('all_messages') ? ' ms_active' : '' }}"
                        href="{{ route('all_messages') }}">
                        <i class="fa-regular fa-envelope me-1 position-relative"><span
                                class="{{ request()->routeIs('all_messages') ? ' ms_dot ' : '' }}">

                            </span></i>
                        Messages</a>
                </li>
                <li class="nav-item">

                    <a class="nav-link{{ request()->routeIs('apartments.create') ? ' ms_active' : '' }}"
                        href="{{ route('apartments.create') }}"><i
                            class="fa-solid fa-plus me-1 position-relative"><span
                                class="{{ request()->routeIs('apartments.create') ? ' ms_dot ' : '' }}">
                            </span></i> New apartments</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('all_sponsorships') ? ' ms_active' : '' }}"
                        href="{{ route('all_sponsorships') }}">
                        <i class="fa-solid fa-coins me-1 position-relative"><span
                                class="{{ request()->routeIs('all_sponsorships') ? ' ms_dot ' : '' }}">
                            </span></i>
                        Sponsor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('views.index') ? ' ms_active' : '' }}"
                        href="{{ route('views.index') }}">
                        <i class="fa-solid fa-chart-simple me-1"></i><span
                            class="{{ request()->routeIs('views.index') ? ' ms_dot ' : '' }}">
                        </span></i>
                        Stats</a>
                </li>

            </ul>

            <!-- Settings Dropdown -->
            @if (Auth::check())
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user me-1"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
