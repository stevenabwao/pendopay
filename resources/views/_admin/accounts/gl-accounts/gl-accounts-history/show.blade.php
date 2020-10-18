@extends('_admin.layouts.master')

@section('title')

    Showing GL Account History Record - {{ $glaccounthistory->gl_account_no }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing GL Account History Record - {{ $glaccounthistory->gl_account_no }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('gl-accounts-history.show', $glaccounthistory->gl_account_no) !!}
          </div>
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
                            GL Account No:
                            <span class="txt-danger">
                            {{ $glaccounthistory->gl_account_no }}
                            </span>
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
                                            <strong>Account Name:</strong>
                                            <span class="text-success">
                                              @if ($glaccounthistory->glaccount)
                                                  {{ $glaccounthistory->glaccount->description }}
                                              @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            <span>
                                                @if ($glaccounthistory->company)
                                                  {{ $glaccounthistory->company->name }}
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Trans Ref Text:</strong>
                                            <span>
                                                {{ $glaccounthistory->tran_ref_txt }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Trans Desc:</strong>
                                            <span>
                                                {{ $glaccounthistory->tran_desc }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>



                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Amount:</strong>
                                            {{ format_num($glaccounthistory->amount) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>

                                           @if ($glaccounthistory->status->id == 1)
                                            <span class="txt-dark text-success">
                                                {{ $glaccounthistory->status->name }}
                                            </span>
                                          @else
                                            <span class="txt-dark text-danger">
                                                {{ $glaccounthistory->status->name }}
                                            </span>
                                          @endif

                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($glaccounthistory->user)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Account User:</strong>
                                            {{ $glaccounthistory->user->first_name }}
                                            {{ $glaccounthistory->user->last_name }}
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


                      {{-- <a
                          href="{{ route('user-savings-accounts.edit', $glaccounthistory->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Account</span>
                      </a> --}}


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
                          <h5><strong>GL Account History Record Details</strong></h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created At:</strong>
                                           {{ formatFriendlyDate($glaccounthistory->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($glaccounthistory->created_by)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           @if ($glaccounthistory->creator)
                                            {{ $glaccounthistory->creator->first_name }}
                                            {{ $glaccounthistory->creator->last_name }}
                                           @else
                                            {{ $glaccounthistory->created_by_name }}
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated At:</strong>
                                           {{ formatFriendlyDate($glaccounthistory->updated_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($glaccounthistory->updated_by)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated By:</strong>
                                           @if ($glaccounthistory->updater)
                                            {{ $glaccounthistory->updater->first_name }}
                                            {{ $glaccounthistory->updater->last_name }}
                                           @else
                                            {{ $glaccounthistory->updated_by_name }}
                                           @endif
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




