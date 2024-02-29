<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom border-gray-100">
    <div class="container-fluid">
        <!-- Logo -->
        <h5>
            BoolBnb
        </h5>

        <!-- Hamburger Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('dashboard') ? ' active' : '' }}" href="{{ url('http://localhost:5173/') }}">
                        <i class="fa-solid fa-house"></i> 
                        HomePage
                    </a>
                </li>
                <li>

                    <a class="nav-link" href="{{route('apartments.index')}}">
                        <i class="fa-solid fa-building"></i> 
                        Apparments</a>


                </li>
                <li>
                    <a class="nav-link" href="{{route('all_messages')}}">
                        <i class="fa-regular fa-envelope"></i> 
                        Messages</a>
                </li>
                <li>

                    <a class="nav-link" href="{{route('apartments.create')}}"><i class="fa-solid fa-plus"></i> New apartments</a>

                    <a class="nav-link" href="{{route('all_sponsorships')}}">Sponsorships</a>
                </li>
            
            </ul>

            <!-- Settings Dropdown -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}  {{ Auth::user()->lastname }}
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
        </div>
    </div>
</nav>
