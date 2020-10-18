@extends('_admin.layouts.master')

@section('title')

    Displaying Group Member

    @if($groupmember->branchmember)
      - {{ $groupmember->branchmember->companyuser->user->first_name }}
        {{ $groupmember->branchmember->companyuser->user->last_name }}
    @endif

@endsection


@section('content')


    <div class="container-fluid">

        <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Group Member
              @if($groupmember->branchmember)
                - {{ $groupmember->branchmember->companyuser->user->first_name }}
                  {{ $groupmember->branchmember->companyuser->user->last_name }}
              @endif
            </h5>
          </div>

          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">

              {!! Breadcrumbs::render('groupmembers.show', $groupmember->id) !!}

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
                                            @if($groupmember->branchmember)
                                                {{ $groupmember->branchmember->companyuser->user->first_name }}
                                                {{ $groupmember->branchmember->companyuser->user->last_name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            {{ $groupmember->company->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>
                                            @if($groupmember->companyuser)
                                            {{ $groupmember->companyuser->user->email }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong>
                                            @if($groupmember->companyuser)
                                            {{ $groupmember->companyuser->user->phone }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created At:</strong>
                                           {{ formatFriendlyDate($groupmember->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if($groupmember->creator)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           {{ $groupmember->creator->first_name }}
                                           {{ $groupmember->creator->last_name }}
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
                          href="{{ route('groupmembers.edit', $groupmember->id) }}"
                          class="btn btn-danger btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-trash"></i>
                          <span class="btn-text">Remove Group Member</span>
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
                          <h5>Group Name</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">

                            <ul class="list-icons">

                                @if ($groupmember->branchgroup)



                                    <li class="mb-10">
                                        <i class="fa fa-genderless text-success mr-5"></i>
                                        {{ $groupmember->branchgroup->name }}
                                    </li>

                                @else

                                    <p class="mb-20">
                                        No group set for member
                                    </p>

                                @endif
                            </ul>

                        </div>
                      </div>

                  </div>

                <div  class="panel-body pb-0 ml-20 mr-20">

                    <p class="mb-20">
                        <h5>Company Name</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">

                          <ul class="list-icons">

                              @if ($groupmember->company)

                                  <li class="mb-10">
                                      <i class="fa fa-genderless text-success mr-5"></i>
                                      {{ $groupmember->company->name }}
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

                            @if ($groupmember->branchmember)

                                <li class="mb-10">
                                    <i class="fa fa-genderless text-success mr-5"></i>
                                    {{ $groupmember->branchmember->companybranch->name }}
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

