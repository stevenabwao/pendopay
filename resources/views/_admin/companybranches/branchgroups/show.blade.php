@extends('_admin.layouts.master')

@section('title')

    Displaying Branch Group - {{ $branchgroup->name }}

@endsection


@section('content')


    <div class="container-fluid">

        <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Branch Group - {{ $branchgroup->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">

              {!! Breadcrumbs::render('branchgroups.show', $branchgroup->id) !!}

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
                                            <strong>Group Description:</strong>
                                            <br>
                                            {{ $branchgroup->description }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company Branch:</strong>
                                            @if($branchgroup->companybranch)
                                              {{ $branchgroup->companybranch->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            {{ $branchgroup->company->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Group Primary User:</strong>
                                            @if($branchgroup->primaryuser)
                                              @if($branchgroup->primaryuser->user)
                                              {{ $branchgroup->primaryuser->user->first_name }}
                                              {{ $branchgroup->primaryuser->user->last_name }}
                                              @endif
                                            @else
                                              None
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Group Email:</strong>
                                            {{ $branchgroup->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Group Phone:</strong>
                                            {{ $branchgroup->phone }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Group Box Number:</strong>
                                           {{ $branchgroup->box }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Group Physical Address:</strong>
                                           {{ $branchgroup->physical_address }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created At:</strong>
                                           {{ formatFriendlyDate($branchgroup->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if($branchgroup->creator)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           {{ $branchgroup->creator->first_name }}
                                           {{ $branchgroup->creator->last_name }}
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
                          href="{{ route('branchgroups.edit', $branchgroup->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Branch Group</span>
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

                              @if ($branchgroup->company)

                                  <li class="mb-10">
                                      <i class="fa fa-genderless text-success mr-5"></i>
                                      {{ $branchgroup->company->name }}
                                  </li>

                              @else

                                  <p class="mb-20">
                                      No company set for group
                                  </p>

                              @endif
                          </ul>

                      </div>
                    </div>

                </div>
              </div>

            </div>

            <div class="panel panel-default card-view pa-0">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20">

                      <p class="mb-20">
                          <h5>Group Members ({{ count($groupmembers) }})</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">

                            <div class="user_options_tall nicescroll-bar">

                                <ul class="list-icons">

                                    @if(count($groupmembers))

                                        @foreach ($groupmembers as $groupmember)
                                        <li class="mb-10">

                                            <i class="fa fa-genderless text-success mr-5"></i>
                                            <strong>
                                                {{ $groupmember->companyuser->user->phone }}
                                            </strong>
                                            &nbsp; - &nbsp;
                                            <span>
                                              <a href="{{ route('users.show', $groupmember->id) }}" class="btn-link">
                                                {{ $groupmember->companyuser->user->first_name }}
                                                &nbsp;
                                                {{ $groupmember->companyuser->user->last_name }}
                                              </a>
                                            </span>

                                        </li>
                                        @endforeach

                                    @else

                                        <p class="mb-20">
                                            There are no members in this group
                                        </p>

                                    @endif

                                </ul>

                                <hr>

                                <div class="text-center">
                                   {{ $groupmembers->links() }}
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


