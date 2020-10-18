@extends('_admin.layouts.master')

@section('title')

    Displaying Company Branch - {{ $companybranch->name }}

@endsection


@section('content')


    <div class="container-fluid pt-10">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Company Branch - {{ $companybranch->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('companybranches.show', $companybranch->id) !!}
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
                          Company Branch Name: <span class="txt-primary">{{ $companybranch->name }}</span>
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
                                            <strong>Company Name:</strong>
                                            {{ $companybranch->company->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Branch Manager:</strong>
                                            @if ($companybranch->manager)
                                              {{ $companybranch->manager->first_name }}
                                              {{ $companybranch->manager->last_name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>
                                            {{ $companybranch->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong>
                                            {{ $companybranch->phone }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Box Number:</strong>
                                           {{ $companybranch->box }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Physical Address:</strong>
                                           {{ $companybranch->physical_address }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong>
                                           {{ formatFriendlyDate($companybranch->created_at) }}
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
                          href="{{ route('companybranches.edit', $companybranch->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Company Branch</span>
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
                        <h5>Branch Stats</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">

                          <ul class="list-icons">

                              <li class="mb-10">
                                  <strong>Branch Groups: </strong>
                                   {{ count($branchgroups) }}
                              </li>

                              <li class="mb-10">
                                  <strong>Branch Members: </strong>
                                   {{ count($branchmembers) }}
                              </li>

                          </ul>

                      </div>
                    </div>

                </div>


                <div  class="panel-body pb-0 ml-20 mr-20">

                    <p class="mb-20">
                        <h5>Branch Groups ({{ count($branchgroups) }})</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">

                          <div class="user_options_tall nicescroll-bar">

                              <ul class="list-icons">

                                  @if(count($branchgroups))

                                      @foreach ($branchgroups as $branchgroup)
                                      <li class="mb-10">

                                          <i class="fa fa-genderless text-success mr-5"></i>
                                          <strong>
                                              {{ $branchgroup->phone }}
                                          </strong>
                                          &nbsp; - &nbsp;
                                          <span>
                                            <a href="{{ route('branchgroups.show', $branchgroup->id) }}" class="btn-link">
                                              {{ $branchgroup->name }}
                                            </a>
                                          </span>

                                      </li>
                                      @endforeach

                                  @else

                                      <p class="mb-20">
                                          There are no groups in this branch
                                      </p>

                                  @endif

                              </ul>

                              <hr>

                              <div class="text-center">
                                 {{ $branchgroups->links() }}
                              </div>

                          </div>

                      </div>
                    </div>

                </div>



                <div  class="panel-body pb-0 ml-20 mr-20">

                    <p class="mb-20">
                        <h5>Branch Members ({{ count($branchmembers) }})</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">

                          <div class="user_options_tall nicescroll-bar">

                              <ul class="list-icons">

                                  @if(count($branchmembers))

                                      @foreach ($branchmembers as $branchmember)
                                      <li class="mb-10">

                                          <i class="fa fa-genderless text-success mr-5"></i>
                                          <strong>
                                              {{ $branchmember->companyuser->user->phone }}
                                          </strong>
                                          &nbsp; - &nbsp;
                                          <span>
                                            <a href="{{ route('users.show', $branchmember->id) }}" class="btn-link">
                                              {{ ucfirst($branchmember->companyuser->user->first_name) }}
                                              {{ ucfirst($branchmember->companyuser->user->last_name) }}
                                            </a>
                                          </span>

                                      </li>
                                      @endforeach

                                  @else

                                      <p class="mb-20">
                                          There are no members in this branch
                                      </p>

                                  @endif

                              </ul>

                              <hr>

                              <div class="text-center">
                                 {{ $branchmembers->links() }}
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

