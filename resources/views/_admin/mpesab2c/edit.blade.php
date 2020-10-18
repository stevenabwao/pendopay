@extends('_admin.layouts.master')


@section('title')

    Edit Yehu Deposit - {{ $yehudeposit->id }} - {{ $yehudeposit->full_name }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit Yehu Deposit - {{ $yehudeposit->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('yehu-deposits.edit', $yehudeposit->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Yehu Deposit - {{ $yehudeposit->id }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('yehu-deposits.update', $yehudeposit->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Full Name</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ $yehudeposit->full_name }}
                                            </label>
                                          </div>

                                       </div>
                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Phone Number</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ $yehudeposit->phone_number }}
                                            </label>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Trans ID</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ $yehudeposit->trans_id }}
                                            </label>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="amount" class="col-sm-3 control-label">
                                             <strong>Amount</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="amount" class="control-label text-left">
                                               {{ format_num($yehudeposit->amount) }}
                                            </label>
                                          </div>

                                       </div>

                                       <hr>

                                       <div  class="form-group{{ $errors->has('acct_no') ? ' has-error' : '' }}">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             Account No
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="acct_no"
                                                name="acct_no"
                                                value="{{ old('acct_no', $yehudeposit->acct_no)}}"
                                                required autofocus>

                                             @if ($errors->has('acct_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('acct_no') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">

                                          <label for="comments" class="col-sm-3 control-label">
                                             Comments
                                          </label>
                                          <div class="col-sm-9">
                                            <textarea
                                                rows="4"
                                                class="form-control"
                                                id="comments"
                                                name="comments"
                                                >{{ old('comments', $yehudeposit->comments)}}</textarea>

                                             @if ($errors->has('comments'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('comments') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                              <button
                                                type="submit"
                                                class="btn btn-lg btn-primary btn-block mr-10"
                                                 id="submit-btn">
                                                 Submit
                                              </button>
                                          </div>
                                       </div>

                                       <br/>

                                    </form>

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


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  @include('_admin.layouts.partials.error_messages')

@endsection
