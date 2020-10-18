@extends('_admin.layouts.master')

@section('title')

    Showing Permission - {{ $permission->display_name }}

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Permission - {{ $permission->display_name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('permissions.show', $permission->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
        <div class="row">

          <div class="col-lg-6 col-xs-12">
            <div class="panel panel-default card-view  pa-0">
              <div class="panel-wrapper collapse in">
                <div class="panel-body  pa-0">
                  <div class="profile-box">
                    <div class="profile-cover-pic">
                      <div class="fileupload btn btn-default">
                        <span class="btn-text">edit</span>
                        <input class="upload" type="file">
                      </div>
                      <div class="profile-image-overlay">
                        <img src="{{ asset('images/mock6.jpg') }}" width="100%" height="100%">
                      </div>
                    </div>
                    <div class="profile-info text-center">

                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font">
                          Permission Name: <span class="txt-danger">{{ $permission->display_name }}</span>
                      </h5>
                      <!-- <h6 class="block capitalize-font pb-20">Developer Geek</h6> -->
                    </div>
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
                                            <strong>Display Name:</strong>
                                            {{ $permission->display_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Slug:</strong>
                                            {{ $permission->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Description:</strong>
                                            {{ $permission->description }}
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

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
        <!-- /Row -->

    </div>


@endsection

