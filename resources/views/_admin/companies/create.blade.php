@extends('_admin.layouts.master')

@section('title')

    Create Establishment

@endsection

@section('page_breadcrumbs')

    {!! Breadcrumbs::render('admin.establishments.create') !!}

@endsection

@section('css_header')

  <link href="{{ asset('_admin/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('_admin/css/dropify.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')


    <div class="container-fluid pt-10">

       <!-- Title -->
       <div class="row heading-bg">

          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Establishment</h5>
          </div>
          <!-- Breadcrumb -->
          @include('_admin.layouts.partials.breadcrumbs')
          <!-- /Breadcrumb -->

       </div>
       <!-- /Title -->

        <!-- Row -->
        <div class="row">

            <form method="POST" enctype="multipart/form-data"
                action="{{ route('admin.establishments.store') }}">

                {{ csrf_field() }}

                <div class="col-lg-6 col-xs-12">

                  <div class="panel panel-default card-view  pa-0 equalheight">
                    <div class="panel-wrapper collapse in">
                      <div class="panel-body  pa-0">
                        <div class="profile-box">

                          <div class="social-info">
                            <div class="row">

                              <div class="followers-wrap">
                                <ul class="followers-list-wrap">
                                  <li class="follow-list">
                                    <div class="follo-body">

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                              <label for="name" class="col-md-5 control-label">
                                                  Establishment Name
                                                  <span class="text-danger"> *</span>
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ old('name', 'Florida Night Club') }}"
                                                    required
                                                    autofocus>

                                                  @if ($errors->has('name'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('name') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                              <label for="description" class="col-md-5 control-label">
                                                  Establishment Description
                                              </label>
                                              <div class="col-md-7">
                                                  <textarea name="description" id="description" rows="5"
                                                    class="form-control">{{ old('description', 'Florida Night Club') }}</textarea>

                                                  @if ($errors->has('description'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('description') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('county_id') ? ' has-error' : '' }}">

                                              <label for="county_id" class="col-md-5 control-label">
                                                  County
                                                  <span class="text-danger"> *</span>
                                              </label>
                                              <div class="col-md-7">

                                                  <select class="selectpicker form-control"
                                                      name="county_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($counties as $county)
                                                      <li class="mb-10">
                                                        <option value="{{ $county->id }}"

                                                          @if ($county->id == old('county_id', 47))
                                                                selected="selected"
                                                          @endif
                                                          >
                                                          {{ $county->name }}

                                                        </option>
                                                      </li>
                                                      @endforeach

                                                  </select>

                                                  @if ($errors->has('county_id'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('county_id') }}</strong>
                                                      </span>
                                                  @endif

                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">

                                              <label for="category_id" class="col-md-5 control-label">
                                                  Establishment Category
                                                  <span class="text-danger"> *</span>
                                              </label>
                                              <div class="col-md-7">

                                                  <select class="selectpicker form-control"
                                                      name="category_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($categories as $category)
                                                      <li class="mb-10">
                                                        <option value="{{ $category->id }}"

                                                          @if ($category->id == old('category_id', 2))
                                                                selected="selected"
                                                          @endif
                                                          >
                                                          {{ $category->name }}

                                                        </option>
                                                      </li>
                                                      @endforeach

                                                  </select>

                                                  @if ($errors->has('category_id'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('category_id') }}</strong>
                                                      </span>
                                                  @endif

                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('paybill_no') ? ' has-error' : '' }}">

                                              <label for="paybill_no" class="col-md-5 control-label">
                                                  Paybill No.
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="paybill_no"
                                                    name="paybill_no"
                                                    value="{{ old('paybill_no', '665443') }}"

                                                    >

                                                  @if ($errors->has('paybill_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('paybill_no') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">

                                              <label for="contact_person" class="col-md-5 control-label">
                                                  Contact Person
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="contact_person"
                                                    name="contact_person"
                                                    value="{{ old('contact_person', 'Kinyua') }}"

                                                    >

                                                  @if ($errors->has('contact_person'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('contact_person') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('personal_phone') ? ' has-error' : '' }}">

                                              <label for="personal_phone" class="col-md-5 control-label">
                                                  Personal Phone
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="personal_phone"
                                                    name="personal_phone"
                                                    value="{{ old('personal_phone', '0722111000') }}"

                                                    >

                                                  @if ($errors->has('personal_phone'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('personal_phone') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                                              <label for="phone" class="col-md-5 control-label">
                                                  Company Phone
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="phone"
                                                    name="phone"
                                                    value="{{ old('phone', '254700222111') }}"

                                                    >

                                                  @if ($errors->has('phone'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('phone') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('personal_email') ? ' has-error' : '' }}">

                                              <label for="personal_email" class="col-md-5 control-label">
                                                  Personal Email
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="personal_email"
                                                    name="personal_email"
                                                    value="{{ old('personal_email', 'kinyua@gmail.com') }}"

                                                    >

                                                  @if ($errors->has('personal_email'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('personal_email') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                              <label for="email" class="col-md-5 control-label">
                                                  Company Email
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="email"
                                                    name="email"
                                                    value="{{ old('email', 'info@florida.co.ke') }}"

                                                    >

                                                  @if ($errors->has('email'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('email') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('town') ? ' has-error' : '' }}">

                                              <label for="town" class="col-md-5 control-label">
                                                  Town
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="town"
                                                    name="town"
                                                    value="{{ old('town', 'Nairobi') }}"
                                                    >

                                                  @if ($errors->has('town'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('town') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('street_address') ? ' has-error' : '' }}">

                                              <label for="street_address" class="col-md-5 control-label">
                                                  Street Address
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="street_address"
                                                    name="street_address"
                                                    value="{{ old('street_address', 'Kimathi Street') }}"
                                                    >

                                                  @if ($errors->has('street_address'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('street_address') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('facebook_url') ? ' has-error' : '' }}">

                                              <label for="facebook_url" class="col-md-5 control-label">
                                                Facebook Page
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="facebook_url"
                                                    name="facebook_url"
                                                    value="{{ old('facebook_url', 'http://facebook.com/florida') }}"
                                                    >

                                                  @if ($errors->has('facebook_url'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('facebook_url') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('twitter_url') ? ' has-error' : '' }}">

                                              <label for="twitter_url" class="col-md-5 control-label">
                                                Twitter Page
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="twitter_url"
                                                    name="twitter_url"
                                                    value="{{ old('twitter_url', 'http://twitter.com/florida') }}"
                                                    >

                                                  @if ($errors->has('twitter_url'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('twitter_url') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('instagram_url') ? ' has-error' : '' }}">

                                              <label for="instagram_url" class="col-md-5 control-label">
                                                  Instagram Page
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="instagram_url"
                                                    name="instagram_url"
                                                    value="{{ old('instagram_url', 'http://instagram.com/florida') }}"
                                                    >

                                                  @if ($errors->has('instagram_url'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('instagram_url') }}</strong>
                                                      </span>
                                                  @endif
                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                              <label for="status_id" class="col-md-5 control-label">
                                                  Status
                                                  <span class="text-danger"> *</span>
                                              </label>
                                              <div class="col-md-7">

                                                  <select class="selectpicker form-control"
                                                      name="status_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($statuses as $status)
                                                      <li class="mb-10">
                                                        <option value="{{ $status->id }}"

                                                          @if ($status->id == old('status_id', '1'))
                                                                selected="selected"
                                                          @endif
                                                          >
                                                          {{ $status->name }}

                                                        </option>
                                                      </li>
                                                      @endforeach

                                                  </select>

                                                  @if ($errors->has('status_id'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('status_id') }}</strong>
                                                      </span>
                                                  @endif

                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                    </div>
                                  </li>
                                </ul>
                              </div>

                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 col-xs-12">
                  <div class="panel panel-default card-view pa-0 equalheight">
                    <div class="panel-wrapper collapse in">
                      <div  class="panel-body pb-0 ml-20 mr-20">

                          <p class="mb-20">
                              <h5>Establishment Photo/ Logo (400 X 400 px)</h5>
                          </p>


                          <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                              <div class="mt-0">
                                  <input type="file" id="input-file-now-custom-3" class="dropify" data-height="400"
                                    data-default-file="" name="item_image"/>
                              </div>
                            </div>
                          </div>

                          <hr>

                          <div class="follo-data">
                            <div class="user-data">
                              <span class="name block">
                                <strong>Establishment Location:</strong>
                                <br><br>
                                <div id="map-canvas" style="min-height:400px;"></div>
                                <br>
                                <input value="{{ old('longitude') }}"
                                    type="hidden" name="longitude" id="longitude">
                                <input value="{{ old('latitude') }}"
                                    type="hidden" name="latitude" id="latitude">
                              </span>
                            </div>
                            <div class="clearfix"></div>
                          </div>

                      </div>
                    </div>
                  </div>

                </div>

                <div class="clearfix"></div>

                <div class="col-xs-12">
                  <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                      <div  class="panel-body pb-0 ml-20 mr-20">

                        <button
                          type="submit"
                          class="btn btn-lg btn-info btn-block mt-10 mb-10"
                           id="submit-btn">
                           Submit
                        </button>

                      </div>
                    </div>
                  </div>
                </div>

            </form>

        </div>
        <!-- /Row -->

    </div>

    {{-- {{ dd($site_settings['default_longitude']) }} --}}

@endsection


@section('page_scripts')

  <script>

    var map; var markers = [];

    function setdata(latStr,lngStr){
        //set values to the divs
        document.getElementById('latitude').value = latStr;
        document.getElementById('longitude').value = lngStr;
    }

    function initializeMap(latitude, longitude) {

      inlat = false; // markers = [];
      if ((latitude == null) || (longitude == null)) {
        latitude = "{{ old('latitude', $site_settings['default_latitude']) }}";
        longitude = "{{ old('longitude', $site_settings['default_longitude']) }}";
        inlat = true;
      }

      var myLatlng = new google.maps.LatLng(latitude, longitude);
      var mapOptions = {
        zoom: 13,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };

      var marker = new google.maps.Marker({
          position: myLatlng,
          map: map
      });

      // Adds a marker to the map and push to the array.
      function placeMarker(location) {
        marker = new google.maps.Marker({
          position: location,
          map: map
        });
        map.panTo(location);
        markers.push(marker);
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

      map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

      if (map != null) {
        marker = new google.maps.Marker({
          position: myLatlng,
          map: map
        });
        map.panTo(myLatlng);
        markers.push(marker);
      }

      google.maps.event.addListener(map,'click',function(event) {
        var latStr = event.latLng.lat();
        var lngStr = event.latLng.lng();
        setdata(latStr,lngStr);
        deleteMarkers();//delete any previous markers
        placeMarker(event.latLng); //set new marker
      })

      google.maps.event.trigger(map, 'resize');

    }

    function loadScript() {
      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'https://maps.googleapis.com/maps/api/js?key=<?=$site_settings['google_maps_key']?>&' +
          'callback=initializeMap';
      document.body.appendChild(script);
    }

    window.onload = loadScript;

  </script>

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('myjs/dropify.min.js') }}"></script>
  <script src="{{ asset('myjs/form-file-upload-data.js') }}"></script>

@endsection


@section('css_header')

    <link href="{{ asset('css/maps.css') }}" rel="stylesheet" type="text/css">

    <style>
      #map-canvas{height: 400px;}
    </style>

@endsection
