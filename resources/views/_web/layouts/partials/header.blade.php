<nav class="menu-top-logo menu-fixed" data-menu-anima="fade-in">
    <div class="container">
        <div class="menu-brand">
            <a href="#">
                 <img class="logo-default scroll-hide" src="{{ asset('images/logo_white.png') }}" alt="PendoPay Logo" />
                <img class="logo-retina scroll-hide" src="{{ asset('images/logo_white.png') }}" alt="PendoPay Logo" />
                <img class="logo-default scroll-show" src="{{ asset('images/logo_white.png') }}" alt="PendoPay Logo" />
                <img class="logo-retina scroll-show" src="{{ asset('images/logo_white.png') }}" alt="PendoPay Logo" />
            </a>
        </div>
        <i class="menu-btn"></i>
        <div class="menu-cnt">
            <ul id="main-menu">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>

                <li>
                    <a href="{{ route('home') }}">About PendoPay</a>
                </li>

                <li class="dropdown">
                    <a href="#">Our Services</a>
                    <ul>
                        <li><a href="{{ route('home') }}">Payments</a></li>
                        <li><a href="{{ route('home') }}">Payments</a></li>
                    </ul>
                </li>

                @if (isLoggedIn())

                    <li class="dropdown">
                        <a href="#">My Account</a>
                        <ul>
                            <li><a href="{{ route('my-transactions.index') }}">My Transactions</a></li>
                            <li><a href="{{ route('my-payments.index') }}">My Payments</a></li>
                            <li><a href="{{ route('my-transfers.index') }}">My Transfers</a></li>
                        </ul>
                    </li>

                @endif

                <li>
                    <a href="{{ route('contacts') }}">Contact Us</a>
                </li>

                @if (isAdminPanelAvailable())
                    <li>
                        <a href="{{ route('admin.home') }}">Admin</a>
                    </li>
                @endif

                <li class="nav-label">
                    <a href="#"><span>Call us:</span> {!! ($site_settings['contact_phone']) !!}</a>
                </li>

            </ul>

            <div class="menu-right">

                <div class="custom-area">
                    {!! ($site_settings['company_location']) !!}
                </div>

                @if (isLoggedIn())
                    <ul class="lan-menu lan-menu-top">
                        <li class="dropdown">
                            <a href="#"><i class="fa fa-user"></i> {{ getLoggedUser()->first_name }} </a>
                            <ul>
                                <li><a href="#"><i class="fa fa-user"></i> My Account</a></li>
                                <li><a href="{{ route('my-transactions.index') }}"><i class="fa fa-briefcase"></i> My Transactions</a></li>
                                <li><a href="{{ route('my-payments.index') }}"><i class="fa fa-money"></i> My Payments</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="fa fa-lock"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <p class="auth-link">
                        <a href="{{ route('login') }}">Login</a> |
                        <a href="{{ route('register') }}">Register</a>
                    </p>
                @endif

            </div>
        </div>
    </div>
</nav>

@include('_web.layouts.partials.breadcrumbs')
