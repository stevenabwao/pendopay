<footer class="light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h3>Connect With Us</h3>
                <p>Connect with {{ config('app.name') }} using our social media links below:</p>
                <div class="icon-links icon-social icon-links-grid social-colors">

                    @if ($site_settings['facebook_page_url'])
                        <a href="{{ $site_settings['facebook_page_url'] }}" target="_blank" class="facebook">
                            <i class="icon-facebook"></i>
                        </a>
                    @endif

                    @if ($site_settings['twitter_page_url'])
                        <a href="{{ $site_settings['twitter_page_url'] }}" target="_blank" class="twitter">
                            <i class="icon-twitter"></i>
                        </a>
                    @endif

                    @if ($site_settings['linkedin_page_url'])
                        <a href="{{ $site_settings['linkedin_page_url'] }}" target="_blank" class="linkedin">
                            <i class="icon-linkedin"></i>
                        </a>
                    @endif

                </div>
            </div>
            <div class="col-lg-4">
                <h3>Quick Links</h3>
                <ul class="icon-list icon-line">
                    <li><a href="#">Partners and advertising</a></li>
                    <li><a href="#">About us and the company</a></li>
                    <li><a href="#">Services and projects</a></li>
                    <li><a href="#">Contact us online</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <ul class="text-list text-list-line">
                    <li><b>Address</b><hr /><p>139 Baker St, E1 7PT, London</p></li>
                    <li><b>Email</b><hr /><p>{!! ($site_settings['contact_email']) !!}</p></li>
                    <li><b>Phone</b><hr /><p>{!! ($site_settings['contact_phone']) !!}</p></li>
                    <li><b>Opening hours</b><hr /><p>8am-5pm Mon - Fri</p></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bar">
        <div class="container">
            <span>
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </span>
            <span><a href="#">Contact us</a> | <a href="#">Privacy policy</a></span>
        </div>
    </div>

</footer>
