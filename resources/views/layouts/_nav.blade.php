<nav class="navbar navbar-expand-lg navbar-dark fixed-top">

    <div class="container">

        <a class="navbar-brand" href="{{ route('welcome') }}">Netflix<span class="text-primary font-weight-bold">ify</span></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">

            <form action="" class="col-12 col-md-6 p-0 mt-1">
                <div class="input-group">
                    <input type="search" id="searchMovie" class="form-control bg-transparent border-0" placeholder="Search for your favorite movies" aria-label="Search for your favorite movies" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-white border-0" id="basic-addon2"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </form><!-- end of form -->

            <ul class="navbar-nav ml-auto ">
                @auth
                <li class="nav-item ">
                    <a href="{{ route('movies.favorites') }}" class="nav-link text-white mr-5" style="position: relative">
                        <i class="fa fa-heart fa-lg"></i>
                        <span data-fav_count="{{ auth::user()->movies->count() }}"
                        class="bg-primary text-white d-flex justify-content-center align-items-center"
                        id="nav__fav_count"
                        style="position: absolute; top: -5px; right: -13px; width:15px; height:15px; border-radius: 50%; padding: 0.8rem; font-size: 12px">
                        {{ auth::user()->movies->count() }}
                        </span>
                    </a>
                </li>

                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth::user()->name }}
                    </a>
                    <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">

                        <a href="{{ route('edit_profile') }}" class="dropdown-item fa fa-user fa-1x">
                            Edit Profile
                        </a>
                        <div class="dropdown-divider"></div>

                        @if (auth::user()->hasRole('super_admin') || auth::user()->hasRole('admin'))
                        <a href="{{ route('dashboard.welcome') }}" class="dropdown-item fa fa-dashboard fa-1x">
                            Dashboard
                        </a>
                        <div class="dropdown-divider"></div>
                        @endif

                        <a class="dropdown-item fa fa-sign-out fa-1x" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                        </a>
                    </div>
                </li>

                @else

                <a href="{{ route('login') }}" class="btn btn-primary mb-2 mb-md-0 mr-0 mr-md-2">Login</a>

                <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>

                @endauth
            </ul>

        </div><!-- end of collapse -->

    </div><!-- end of container fluid-->

</nav><!-- end of nav -->
