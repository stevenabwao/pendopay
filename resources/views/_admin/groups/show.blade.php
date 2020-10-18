@extends('_admin.layouts.master')

@section('title')

    Displaying Group - {{ $group->name }}

@endsection


@section('content')


    <div class="container-fluid">

        <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Group - {{ $group->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">

              {!! Breadcrumbs::render('groups.show', $group->id) !!}

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

                    <!-- <div class="profile-info text-left">

                      <h5 class="block mt-10 mb-5 weight-500 capitalize-font ml-20">
                          <span class="txt-primary">{{ $group->name }}</span>
                      </h5>

                    </div>  -->
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
                                            {{ $group->description }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            {{ $group->company->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Email:</strong>
                                            {{ $group->email }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Phone:</strong>
                                            {{ $group->phone_number }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Box Number:</strong>
                                           {{ $group->box }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Physical Address:</strong>
                                           {{ $group->physical_address }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong>
                                           {{ formatFriendlyDate($group->created_at) }}
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
                          href="{{ route('groups.edit', $group->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Group</span>
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

                              @if ($group->company)

                                  <li class="mb-10">
                                      <i class="fa fa-genderless text-success mr-5"></i>
                                      {{ $group->company->name }}
                                  </li>

                              @else

                                  <p class="mb-20">
                                      No company set for user
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
                          <h5>Group Members ({{ count($users) }})</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-sm-12">

                            <div class="user_options_tall nicescroll-bar">

                                <ul class="list-icons">

                                    @if(count($users))

                                        @foreach ($users as $user)
                                        <li class="mb-10">

                                            <i class="fa fa-genderless text-success mr-5"></i>
                                            <strong>
                                                {{ $user->phone_number }}
                                            </strong>
                                            &nbsp; - &nbsp;
                                            <span>
                                              <a href="{{ route('users.show', $user->id) }}" class="btn-link">
                                                {{ $user->first_name }}
                                                &nbsp;
                                                {{ $user->last_name }}
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
                                   {{ $users->links() }}
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


@section('page_scripts')
  <script>

      /*document.getElementById("image").onchange = function() {
          document.getElementById("profileImageForm").submit();
      };*/

      $(document).ready(function(){
          $('#image').change(function() {
            $('#profileImageForm').submit();
          });
      });

  </script>
@endsection

