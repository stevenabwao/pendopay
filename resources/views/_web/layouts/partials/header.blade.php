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
                            <li><a href="{{ route('home') }}">My Transactions</a></li>
                            <li><a href="{{ route('home') }}">My Payments</a></li>
                        </ul>
                    </li>

                @endif

                <li>
                    <a href="{{ route('home') }}">Contact Us</a>
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
                    Mombasa Road<br />
                    Nairobi, Kenya
                </div>
                {{-- <div class="shop-menu-cnt">
                    <i></i>
                    <div class="shop-menu">
                        <ul class="shop-cart">
                            <li class="cart-item">
                                <img src="{{ asset('images/shop/shop-2.png') }}" alt="">
                                <div class="cart-content">
                                    <h5>Adobe XD Tutorial</h5>
                                    <span class="cart-quantity">
                                        1 x $99.00
                                    </span>
                                </div>
                            </li>
                            <li class="cart-item">
                                <img src="{{ asset('images/shop/shop-6.png') }}" alt="">
                                <div class="cart-content">
                                    <h5>Professional Adobe XD</h5>
                                    <span class="cart-quantity">
                                        1 x $99.00
                                    </span>
                                </div>
                            </li>
                        </ul>
                        <p class="cart-total">
                            Subtotal: <span>$299.00</span>
                        </p>
                        <p class="cart-buttons">
                            <a href="#" class="cart-view">View Cart</a>
                            <a href="#" class="cart-checkout">Checkout</a>
                        </p>
                    </div>
                </div>
                <form role="search" method="get" id="searchform" class="search-btn">
                    <div class="search-box-menu">
                        <input type="text" placeholder="Search ...">
                        <i></i>
                    </div>
                </form> --}}

                @if (isLoggedIn())
                    <ul class="lan-menu">
                        <li class="dropdown">
                            <a href="#"><i class="fa fa-user"></i> {{ getLoggedUser()->first_name }} </a>
                            <ul>
                                <li><a href="#"><i class="fa fa-user"></i> My Account</a></li>
                                <li><a href="#"><i class="fa fa-briefcase"></i> My Transactions</a></li>
                                <li><a href="#"><i class="fa fa-money"></i> My Payments</a></li>
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
