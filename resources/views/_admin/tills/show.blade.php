@extends('_admin.layouts.master')

@section('title')
    Showing Till - {{ $till->till_number }}
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.tills.show', $till->id) !!}
@endsection

@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing till - {{ $till->till_number }}</h5>
          </div>
          <!-- Breadcrumb -->
          @include('_admin.layouts.partials.breadcrumbs')
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
        <div class="row mt-15">


          @include('_admin.layouts.partials.error_text')


          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0 equalheight">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                    <p class="mb-20">
                          <h5>
                            Till Number: {!! showStatusText($till->status->id, "", "", $till->till_number) !!}
                          </h5>
                    </p>

                    <hr>

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
                                            <strong>Till Name:</strong>
                                            {{ $till->till_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if($till->status)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block capitalize-font">
                                                    <strong>Status:</strong>
                                                    {!! showStatusText($till->status->id) !!}
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endif

                                    @if($till->active)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block capitalize-font">
                                                    <strong>Is Till Active?:</strong>
                                                    {!! showActiveStatusText($till->active)  !!}
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endif

                                    @if($till->company)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block capitalize-font">
                                                    <strong>Company:</strong>
                                                    {{ $till->company->name }}
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endif

                                    @if($till->created_at)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block">
                                                <strong>Created:</strong>
                                                {{ formatFriendlyDate($till->created_at) }}
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
                          href="{{ route('admin.tills.edit', $till->id) }}"
                          class="btn btn-primary btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Till</span>
                      </a>

                      @if ($till->status->id == config('constants.status.notconfirmed'))
                        <a
                            href="{{ route('admin.tills.confirm-till-create', $till->id) }}"
                            class="btn btn-success btn-block btn-outline btn-anim mt-30">
                            <i class="fa fa-check"></i>
                            <span class="btn-text">Confirm Till</span>
                        </a>
                      @endif

                    </div>
                  </div>

              </div>

            </div>
          </div>

          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0 equalheight">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                      <p class="mb-20">
                          <h5>Till Details</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    @if($till->confirmed_at)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block">
                                                <strong>Confirmed At:</strong>
                                                {{ formatFriendlyDate($till->confirmed_at) }}
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @else
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block">
                                                <strong>Not Yet Confirmed</strong>
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endif

                                    @if($till->created_at)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block">
                                                <strong>Created At:</strong>
                                                {{ formatFriendlyDate($till->created_at) }}
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endif

                                    @if($till->creator)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block">
                                                <strong>Created By:</strong>
                                                @if ($till->creator)
                                                    {{ $till->creator->first_name }}
                                                    {{ $till->creator->last_name }}
                                                @endif
                                                </span>
                                            </div>
                                        <div class="clearfix"></div>
                                        </div>
                                    @endif

                                    @if($till->updated_at)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block">
                                                <strong>Updated At:</strong>
                                                {{ formatFriendlyDate($till->updated_at) }}
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endif

                                    @if($till->updater)
                                        <div class="follo-data">
                                            <div class="user-data">
                                                <span class="name block">
                                                <strong>Updated By:</strong>
                                                {{ $till->updater->first_name }}
                                                {{ $till->updater->last_name }}
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

                  </div>

              </div>

            </div>

          </div>
        </div>
        <!-- /Row -->

    </div>

@endsection

