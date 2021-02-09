<header class="app-header"><a class="app-header__logo" href="{{ route('dashboard.welcome') }}" style="font-family: 'lato', sans-serif">Netflixify</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->

    <ul class="app-nav">


    <!-- User Menu-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu  dropdown-menu-right">
            <li>
                <a href="{{ route('welcome') }}" class="dropdown-item fa fa-home fa-lg">
                    Home
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item fa fa-sign-out fa-lg" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </a>
            </li>
        </ul>
    </li>
    </ul>
</header>
