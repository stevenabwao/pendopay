@extends('_admin.layouts.master')

@section('title')

    Displaying Branch Member

    @if($branchmember->companyuser)
      - {{ $branchmember->companyuser->user->first_name }}
        {{ $branchmember->companyuser->user->last_name }}
    @endif

@endsection


@section('content')


    <div class="container-fluid">

        <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Branch Member
              @if($branchmember->companyuser)
                - {{ $branchmember->companyuser->user->first_name }}
                  {{ $branchmember->companyuser->user->last_name }}
              @endif
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">

              {!! Breadcrumbs::render('branchmembers.show', $branchmember->id) !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

        <!-- Row -->
        <div class="row pt-15">

          <div class="col-lg-6 col-xs-12">
            <div class="panel panel-default card-view  pa-0">
              <div class="panel-wrapper collapse in">
                <div class="panel-body  pa-0">
                  <div class="profile-box">

                    <div class="profile-cover-pic">

                      <form id="profileImageForm" method="post" action="{{ route('images.store') }}"
                          enctype="multipart/form-data">
                          <div class="fileupload btn btn-default">
                              <span class="btn-text">edit</span>
                              <input class="upload" type="file" id="image" name="image">
                          </div>
                      </form>
                      <div class="profile-image-overlay">
                        <img src="{{ asset('images/mock6.jpg') }}" width="100%" height="100%">
                      </div>

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
                                            <strong>Full Name:</strong>
                                            @if($branchmember->companyuser)
                                            {{ $branchmember->companyuser->user->first_name }}
                                            {{ $branchmember->companyuser->user->last_name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company Branch:</strong>
                                            @if($branchmember->companybranch)
                                              {{ $branchmember->companybranch->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            {{ $branchmember->company->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>
                                            @if($branchmember->companyuser)
                                            {{ $branchmember->companyuser->user->email }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong>
                                            @if($branchmember->companyuser)
                                            {{ $branchmember->companyuser->user->phone }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created At:</strong>
                                           {{ formatFriendlyDate($branchmember->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if($branchmember->creator)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           {{ $branchmember->creator->first_name }}
                                           {{ $branchmember->creator->last_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>

                      </div>

                      <a
                          href="{{ route('branchmembers.edit', $branchmember->id) }}"
                          class="btn btn-danger btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-trash"></i>
                          <span class="btn-text">Remove Branch Member</span>
                      </a>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0">
              <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">

                    <p class="mb-20">
                        <h5>Company</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">

                          <ul class="list-icons">

                              @if ($branchmember->company)

                                  <li class="mb-10">
                                      <i class="fa fa-genderless text-success mr-5"></i>
                                      {{ $branchmember->company->name }}
                                  </li>

                              @else

                                  <p class="mb-20">
                                      No company set for member
                                  </p>

                              @endif
                          </ul>

                      </div>
                    </div>

                </div>

                <div  class="panel-body pb-0 ml-20 mr-20">

                  <p class="mb-20">
                      <h5>Branch Name</h5>
                  </p>

                  <hr>

                  <div class="row">
                    <div class="col-sm-12">

                        <ul class="list-icons">

                            @if ($branchmember->companybranch)

                                <li class="mb-10">
                                    <i class="fa fa-genderless text-success mr-5"></i>
                                    {{ $branchmember->companybranch->name }}
                                </li>

                            @else

                                <p class="mb-20">
                                    No branch set for member
                                </p>

                            @endif
                        </ul>

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

