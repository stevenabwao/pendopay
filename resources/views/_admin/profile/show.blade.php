@extends('_admin.layouts.master')

@section('title')

    Showing {{ $user->first_name }}

@endsection


@section('content')


    <div class="container-fluid pt-10">

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
                      <div class="profile-image-overlay"></div>
                    </div>
                    <div class="profile-info text-center">
                      <div class="profile-img-wrap">
                        <img class="inline-block mb-10" src="{{ asset('images/no_user.jpg') }}" alt="{{ $user->first_name }}"/>
                        <div class="fileupload btn btn-default">
                          <span class="btn-text">edit</span>
                          <input class="upload" type="file">
                        </div>
                      </div>
                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-danger">
                          {{ $user->first_name }}
                          &nbsp;
                          {{ $user->last_name }}
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
                                        <span class="name block">
                                            <strong>Account Number:</strong>
                                            {{ $user->account_number }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Name:</strong>
                                            {{ $user->first_name }}&nbsp;{{ $user->last_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>
                                            {{ $user->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong>
                                            {{ $user->phone }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                           <strong>Gender:</strong>
                                           @if(strtolower($user->gender) == 'f')
                                             Female
                                           @else
                                             Male
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
                          href="{{ route('users.edit', $user->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">edit user</span>
                      </a>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-xs-12">

            @if (Auth::user()->hasRole('superadministrator'))

              @if ($user->company)
              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div  class="panel-body pb-0 ml-20 mr-20">

                      <p class="mb-20">
                          <h5>Company</h5>
                      </p>

                      <hr>

                      <div class="follo-data mb-20">
                        <div class="user-data">
                          <span class="name block capitalize-font">
                             <strong>{{ $user->company->name }}</strong>
                          </span>
                        </div>
                        <div class="clearfix"></div>
                      </div>

                  </div>
                </div>
              </div>
              @endif

              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div  class="panel-body pb-0 ml-20 mr-20">

                      <p class="mb-20">
                          <h5>User Roles</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">

                            <p class="mb-20">
                              {{ $user->roles->count() == 0 ? 'This user has no assigned role yet' : '' }}
                            </p>

                            <ul class="list-icons mb-20">
                                @foreach ($user->roles as $role)
                                <li class="mt-10">
                                    <i class="fa fa-genderless text-success mr-5"></i>
                                    {{ $role->display_name }}
                                    <em class="ml-15"> ({{ $role->description }})</em>
                                </li>
                                @endforeach
                            </ul>

                        </div>
                      </div>

                  </div>
                </div>
              </div>

            @endif

            <div class="panel panel-default card-view pa-0">
              <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">

                    <p class="mb-20">
                        <h5>User Groups</h5>
                    </p>

                    <hr>

                    <div class="row">
                      <div class="col-sm-12">

                          <p class="mb-20">
                            {{ $user->groups->count() == 0 ? 'This user has no assigned groups yet' : '' }}
                          </p>

                          <ul class="list-icons mb-20">
                              @foreach ($user->groups as $group)
                              <li class="mt-10">
                                  <i class="fa fa-genderless text-success mr-5"></i>
                                  <strong>{{ $group->name }}</strong>
                                  <em class="ml-15"> ({{ $group->description }})</em>
                              </li>
                              @endforeach
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

