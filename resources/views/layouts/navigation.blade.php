<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="logo-back me-4">
            <img src="{{ URL::asset('/img/b.png') }}">
        </div>

        <!-- Hamburger Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"
                        href="{{ url('http://localhost:5173/') }}">
                        <i class="fa-solid fa-house nav-item"></i>
                        HomePage
                    </a>
                </li>
                <li class="position-relative">

                    <a class="nav-link{{ request()->routeIs('apartments.index') ? ' ms_active' : '' }}"
                        href="{{ route('apartments.index') }}">
                        <i class="fa-solid fa-building position-relative"><span
                                class="{{ request()->routeIs('apartments.index') ? ' ms_dot ' : '' }}">
                                @if (request()->routeIs('apartments.index'))
                                    .
                                @endif
                            </span></i>
                        Apartments</a>


                </li>
                <li class="position-relative">
                    <a class="nav-link{{ request()->routeIs('all_messages') ? ' ms_active' : '' }}"
                        href="{{ route('all_messages') }}">
                        <i class="fa-regular fa-envelope position-relative"><span
                                class="{{ request()->routeIs('all_messages') ? ' ms_dot ' : '' }}">
                                @if (request()->routeIs('all_messages'))
                                    .
                                @endif
                            </span></i>
                        Messages</a>
                </li>
                <li class="position-relative">

                    <a class="nav-link{{ request()->routeIs('apartments.create') ? ' ms_active' : '' }}"
                        href="{{ route('apartments.create') }}"><i class="fa-solid fa-plus position-relative"><span
                                class="{{ request()->routeIs('apartments.create') ? ' ms_dot ' : '' }}">
                                @if (request()->routeIs('apartments.create'))
                                    .
                                @endif
                            </span></i> New apartments</a>

                </li>
                <li class="position-relative">
                    <a class="nav-link{{ request()->routeIs('all_sponsorships') ? ' ms_active' : '' }}"
                        href="{{ route('all_sponsorships') }}">
                        <i class="fa-solid fa-coins position-relative"><span
                                class="{{ request()->routeIs('all_sponsorships') ? ' ms_dot ' : '' }}">
                                @if (request()->routeIs('all_sponsorships'))
                                    .
                                @endif
                            </span></i>
                        Sponsorships</a>
                </li>

            </ul>

            <!-- Settings Dropdown -->
            @if (Auth::check())
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
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
