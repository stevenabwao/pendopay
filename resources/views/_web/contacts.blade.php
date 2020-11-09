@extends('_web.layouts.master')

@section('title')
    Contact Us
@endsection

@section('page_title')
    Contact Us
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('contacts.index') !!}
@endsection

@section('content')

    <section class="section-base section-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 equalheight">

                    <div class="title">
                        <h3 class="title-caps">Talk To Us</h3>
                    </div>
                    <hr>
                    <form action="{{ route('contacts.store') }}" class="form-box contact-us-form" method="post">

                        {{ csrf_field() }}

                        @if (session('error'))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger text-center">
                                        {!! session('error') !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (session('success'))

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-success text-center">
                                        {!! session('success') !!}
                                    </div>
                                </div>
                            </div>

                        @else

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="md-form mat-2 mx-auto">
                                        <input type="text" value="{{ old('subject', 'Test subject') }}" name="subject" required>
                                        <label for="subject">Subject <span class="text-danger">*</span></label>
                                        @if ($errors->has('subject'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('subject') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="md-form mat-2 mx-auto">
                                        <input type="text" value="{{ old('name', 'King Marley') }}" name="name" required>
                                        <label for="name">Your Full Names <span class="text-danger">*</span></label>
                                        @if ($errors->has('name'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="md-form mat-2 mx-auto">
                                        <input type="text" value="{{ old('phone', '0720743211') }}" name="phone">
                                        <label for="phone">Your Phone <span class="text-danger">*</span></label>
                                        @if ($errors->has('phone'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="md-form mat-2 mx-auto">
                                        <input type="text" value="{{ old('email', 'antiv_boy@yahoo.com') }}" name="email">
                                        <label for="email">Your Email</label>
                                        @if ($errors->has('email'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="md-form mat-2 mx-auto">
                                        <textarea id="message" name="message" class="input-textarea" placeholder="" required>{{ old('message', 'Test message') }}</textarea>
                                        <label for="message">Your Message <span class="text-danger">*</span></label>
                                        @if ($errors->has('message'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12">

                                    <hr>

                                    <div class="form-group {{ $errors->has('g-recaptcha') ? ' has-error' : '' }}">
                                        <label class="label" style="color:#666;">Confirm the security box below:
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <div class="g-recaptcha" data-sitekey="{{ $site_settings['recaptcha_site_key'] }}"></div>
                                    </div>

                                    <hr>

                                </div>

                            </div>

                            <button class="btn btn-xs" type="submit">Send message</button>

                        @endif

                    </form>

                </div>
                <div class="col-lg-4">
                    <hr class="space visible-md" />
                    <div class="boxed-area equalheight">
                        <h3 class="sb-title">Get In Touch</h3>
                        <p>Use this page to send us your comments, questions or feedback:</p>

                        <ul class="text-list text-list-line">
                            <li><b>Address</b><hr /><p>{!! $site_settings['company_location_plain'] !!}</p></li>
                            <li><b>Web</b><hr /><p>{!! $site_settings['contact_website'] !!}</p></li>
                            <li><b>Email</b><hr /><p>{!! $site_settings['contact_email'] !!}</p></li>
                            <li><b>Phone</b><hr /><p>{!! $site_settings['contact_phone'] !!}</p></li>
                        </ul>
                        <hr class="space-sm" />
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

                </div>
            </div>
        </div>
    </section>

    <section class="section-base section-full-width no-padding">
        <div class="container">
            {{-- <h3 class="sb-title" style="margin-top:40px;">Our Location</h3> --}}
            <div id="map" style="height:480px;"></div>

            {{-- <div class="google-map" data-marker="media/marker.png" data-zoom="12" data-coords="51.5156177,-0.0919983"></div> --}}
        </div>
    </section>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

@endsection

@section('page_scripts')

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script src="http://maps.google.com/maps/api/js?key={{ $site_settings['google_maps_key'] }}"></script>

    <script>

            if($('#map').length) {
                var map;
                var myLatLng=new google.maps.LatLng({{ $site_settings['company_office_1_latitude'] }}, {{ $site_settings['company_office_1_longitude'] }});
                var myOptions= {
                    zoom:18,
                    center:myLatLng,
                    zoomControl:true,
                    mapTypeId:google.maps.MapTypeId.ROADMAP,
                    mapTypeControl:false,
                    styles:[ {
                        saturation: -100, lightness: 10
                    }
                    ],
                }
                map=new google.maps.Map(document.getElementById('map'), myOptions);
                var marker=new google.maps.Marker( {
                    position: map.getCenter(),
                    map: map,
                    icon: {
                        url: "{{ asset('images/map-marker.png') }}"
                    }
                });
                marker.getPosition();

                // info window
                var contentString = '<div id="content">' +
                    '<div id="siteNotice">' +
                    '</div>' +
                    '<h2 id="firstHeading" class="firstHeading">{!! $site_settings['company_full_name_ltd'] !!}</h2>' +
                    '<div id="bodyContent">' +
                    /* '<p>{!! $site_settings['company_full_name_ltd'] !!}, <br>' + */
                    '<p>{!! $site_settings['company_location_plain_map'] !!}</p>' +
                    '</div>' +
                    '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                infowindow.open(map, marker);

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });

            }


    </script>

@endsection

