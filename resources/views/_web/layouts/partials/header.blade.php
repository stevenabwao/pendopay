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

                <li class="dropdown">
                    <a href="#">Pages</a>
                    <ul>
                        <li class="dropdown-submenu">
                            <a>About</a>
                            <ul>
                                <li><a href="about.html">About</a></li>
                                <li><a href="team.html">Team</a></li>
                                <li><a href="history.html">History</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="#">Services</a>
                            <ul>
                                <li><a href="service-1.html">Security audits</a></li>
                                <li><a href="service-2.html">Artificial intelligence</a></li>
                                <li><a href="service-3.html">Bots and support</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a>Others</a>
                            <ul>
                                <li><a href="prices.html">Prices</a></li>
                                <li><a href="faq.html">Faq</a></li>
                                <li><a href="events.html">Events</a></li>
                                <li><a href="gallery.html">Gallery</a></li>
                                <li><a href="career.html">Career</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="elements/components/buttons.html">Elements</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Projects</a>
                    <ul>
                        <li class="dropdown-submenu">
                            <a>Projects list</a>
                            <ul>
                                <li><a href="projects-1.html">Projects one</a></li>
                                <li><a href="projects-2.html">Projects two</a></li>
                                <li><a href="projects-3.html">Projects three</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a>Project details</a>
                            <ul>
                                <li><a href="project-1.html">Project details one</a></li>
                                <li><a href="project-2.html">Project details two</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Blog</a>
                    <ul>
                        <li><a href="blog-1.html">Classic</a></li>
                        <li><a href="blog-2.html">Grid</a></li>
                        <li><a href="blog-3.html">Masonry</a></li>
                        <li class="dropdown-submenu">
                            <a>Posts</a>
                            <ul>
                                <li><a href="post-1.html">Post one</a></li>
                                <li><a href="post-2.html">Post two</a></li>
                                <li><a href="post-3.html">Post three</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Contacts</a>
                    <ul>
                        <li><a href="contacts-1.html">Contacts one</a></li>
                        <li><a href="contacts-2.html">Contacts two</a></li>
                        <li><a href="contacts-3.html">Contacts three</a></li>
                    </ul>
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
                <div class="shop-menu-cnt">
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
                </form>

                @if (isLoggedIn())
                    <ul class="lan-menu">
                        <li class="dropdown">
                            <a href="#"><img src="{{ asset('images/en.png') }}" alt="lang" />{{ getLoggedUser()->first_name }} </a>
                            <ul>
                                <li><a href="#"><i class="fa fa-user"></i> My Account</a></li>
                                <li><a href="#"><i class="fa fa-briefcase"></i> Transactions</a></li>
                                <li><a href="#"><i class="fa fa-money"></i> Payments</a></li>
                                <li><a href="#"><i class="fa fa-lock"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</nav>
