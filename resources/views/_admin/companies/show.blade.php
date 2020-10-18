@extends('_admin.layouts.master')

@section('title')

    Displaying Establishment - {{ $company->display_name }}

@endsection

@section('page_breadcrumbs')

    {!! Breadcrumbs::render('admin.establishments.show', $company->id) !!}

@endsection


@section('content')


    <div class="container-fluid pt-10">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Establishment - {{ $company->display_name }}</h5>
          </div>

          <!-- Breadcrumb -->
          @include('_admin.layouts.partials.breadcrumbs')
          <!-- /Breadcrumb -->

       </div>
       <!-- /Title -->

        <!-- Row -->
        <div class="row">

          <div class="col-lg-6 col-xs-12">
            <div class="panel panel-default card-view  pa-0 equalheight">
              <div class="panel-wrapper collapse in">
                <div class="panel-body  pa-0">
                  <div class="profile-box">

                    <div class="social-info">
                      <div class="row">

                          <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Establishment Name:</strong>
                                            {!! showStatusText($company->status_id, "", "", $company->display_name) !!}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                          <strong>Establishment Description:</strong>
                                          @if ($company->description)
                                            {{ $company->description }}
                                          @else
                                            <span class="text-danger">No description</span>
                                          @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>County:</strong>
                                            @if($company->county)
                                            {{ $company->county->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Establishment Category:</strong>
                                            @if($company->category)
                                            {{ $company->category->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Paybill No:</strong>
                                            {{ $company->paybill_no }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Personal Phone:</strong>
                                            {{ $company->personal_phone }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                  <div class="follo-data">
                                      <div class="user-data">
                                    <span class="name block">
                                        <strong>Company Phone:</strong>
                                        {{ $company->phone }}
                                    </span>
                                      </div>
                                      <div class="clearfix"></div>
                                  </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Personal Email:</strong>
                                            {{ $company->personal_email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>
                                            {{ $company->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Town:</strong>
                                           {{ $company->town }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Street Address:</strong>
                                           {{ $company->street_address }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($company->facebook_url)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Facebook Page:</strong>
                                           {{ $company->facebook_url }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    @if ($company->twitter_url)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Twitter Page:</strong>
                                           {{ $company->twitter_url }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    @if ($company->instagram_url)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Instagram Page:</strong>
                                           {{ $company->instagram_url }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong>
                                           {{ formatFriendlyDate($company->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>
                                           @if ($company->status)
                                                {!! showStatusText($company->status_id, "", "", $company->status->name) !!}
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>

                      </div>

                      <a
                          href="{{ route('admin.establishments.edit', $company->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Establishment</span>
                      </a>

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
                    <h5>Establishment Photo/ Logo</h5>
                  </p>


                  <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                      <div class="mt-0">
                          @if($company->main_image)
                            <img src="{{ asset($company->main_image) }}" style="min-height:400px;"/>
                          @else
                            <span class="text-danger">{{ getNoImageText() }}</span>
                          @endif
                      </div>
                    </div>
                  </div>

                  <hr>

                    {{-- <div class="row">
                      <div class="col-sm-12">

                          <ul class="list-icons">
                              <li class="mb-10">
                                  <strong>Members: </strong>
                                  {{ count($company->companyusers) }}
                              </li>
                          </ul>

                      </div>
                    </div>

                    <hr> --}}

                    <div class="follo-data">
                      <div class="user-data">
                        <span class="name block">

                           <strong>Establishment Location:</strong>
                           <br><br>

                           @if (($company->latitude) && ($company->longitude))
                            <div id="map-canvas"></div>
                            <br>
                           @else
                            <span class="text-danger">No location set</span>
                           @endif

                        </span>
                      </div>
                      <div class="clearfix"></div>
                    </div>

                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- /Row -->

    </div>

    {{-- {{ dd($site_settings['default_longitude']) }} --}}

@endsection


@section('page_scripts')

  <script>
    //MAPS
    function showmap() {

      if($('#map-canvas').length){
        var map;
        var myLatLng=new google.maps.LatLng("{{ $company->latitude }}", "{{ $company->longitude }}");
        var myOptions={
          zoom:16,
          center:myLatLng,
          zoomControl:true,
          mapTypeId:google.maps.MapTypeId.ROADMAP,
          mapTypeControl:false,
          styles:[{
            saturation:-100,
            lightness:10
          }],
        }
        map=new google.maps.Map(document.getElementById('map-canvas'), myOptions);
        var marker=new google.maps.Marker({
              position:map.getCenter(),
              map:map,
              icon:'http://barddy.co.ke/images/map-icon.png'
        });
        marker.getPosition();
      }

    }
    //END MAPS



    var map; var markers = [];

      function initializeMap(latitude, longitude) {
        /* inlat = false; // markers = [];
        if ((latitude == null) || (longitude == null)) {
          latitude = "{{ $site_settings['default_latitude'] }}";
          longitude = "{{ $site_settings['default_longitude'] }}";
          inlat = true;
        } */

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
      /* function placeMarker(location) {
        marker = new google.maps.Marker({
          position: location,
          map: map
        });
        map.panTo(location);
        markers.push(marker);
      } */

      // Sets the map on all markers in the array.
      /* function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
        }
      }   */

      // Removes the markers from the map, but keeps them in the array.
      /* function clearMarkers() {
        setMapOnAll(null);
      }  */

      // Removes the markers from the map, but keeps them in the array.
      /* function clearMarkers2() {
        setMapOnAll(map2);
      }  */

      map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

      /* map2 = new google.maps.Map(document.getElementById('map-canvas2'),
        mapOptions); */

      if (map != null) {
        /* marker = new google.maps.Marker({
        position: myLatlng,
        map: map
        });
        map.panTo(myLatlng);  */
        //placeMarker(myLatlng);
        showmap();
      }

      /* google.maps.event.addListener(map2,'click',function(event) {
        var latStr = event.latLng.lat();
        var lngStr = event.latLng.lng();
        setdata2(latStr,lngStr);
        deleteMarkers();//delete any previous markers
        placeMarker2(event.latLng); //set new marker
      })  */

      //google.maps.event.trigger(map, 'resize');

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

@endsection

@section('css_header')

    <link href="{{ asset('css/maps.css') }}" rel="stylesheet" type="text/css">

    <style>
      #map-canvas{min-height: 400px;}
    </style>

@endsection
