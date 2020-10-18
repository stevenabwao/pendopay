@extends('_admin.layouts.master')

@section('title')

    Create New Asset

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/dropify.min.css?x=123') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create New Asset</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('assets.create') !!}
          </div>
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
                                    <h3 class="text-center txt-dark mb-10">Create New Asset</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('assets.store') }}"
                                        enctype="multipart/form-data">

                                       {{ csrf_field() }}


                                       {{-- <div  class="form-group{{ $errors->has('asset_url') ? ' has-error' : '' }}">

                                          <label for="asset_url" class="col-sm-3 control-label">
                                             Asset URL/ Path
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="file"
                                                class="form-control"
                                                id="asset_url"
                                                name="asset_url"
                                                value="{{ old('asset_url') }}">

                                             @if ($errors->has('asset_url'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('asset_url') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div> --}}

                                       <div  class="form-group{{ $errors->has('asset_url') ? ' has-error' : '' }}">

                                            <label for="asset_url" class="col-sm-3 control-label">
                                               Asset URL/ Path
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="panel panel-default card-view">

                                                    <div class="panel-wrapper collapse in">
                                                        <div class="panel-body">
                                                            <div class="mt-40">

                                                                <input type="file"
                                                                    id="input-file-now-custom-2"
                                                                    class="dropify"
                                                                    data-height="200"
                                                                    name="asset_url"
                                                                    value="{{ old('asset_url') }}"/>

                                                                @if ($errors->has('asset_url'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('asset_url') }}</strong>
                                                                    </span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                       <div  class="form-group{{ $errors->has('asset_type_id') ? ' has-error' : '' }}">

                                            <label for="asset_type_id" class="col-sm-3 control-label">
                                            Asset Type
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                                <select class="selectpicker form-control"
                                                    name="asset_type_id"
                                                    data-style="form-control btn-default btn-outline"
                                                    required>

                                                    @foreach ($assettypes as $assettype)
                                                        <li class="mb-10">
                                                            <option value="{{ $assettype->id }}"
                                                                @if ($assettype->id == old('asset_type_id', $assettype->id))
                                                                    selected="selected"
                                                                @endif
                                                                >
                                                                {{ $assettype->name }}
                                                            </option>
                                                        </li>
                                                    @endforeach

                                                </select>

                                                @if ($errors->has('asset_type_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('asset_type_id') }}</strong>
                                                        </span>
                                                @endif

                                            </div>

                                        </div>


                                        <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                            <label for="name" class="col-sm-3 control-label">
                                                Asset Name
                                                <a href="#" title="For example Image Name" data-toggle="tooltip" class="ml-10">
                                                    <i class="zmdi zmdi-info"  style="font-size: 20px"></i>
                                                </a>
                                            </label>
                                            <div class="col-sm-9">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ old('name') }}">

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>


                                        <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                            <label for="company_id" class="col-sm-3 control-label">
                                                Company Name
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                                <select class="selectpicker form-control"
                                                    name="company_id"
                                                    data-style="form-control btn-default btn-outline"
                                                    required>

                                                    @foreach ($companies as $company)
                                                    <li class="mb-10">
                                                    <option value="{{ $company->id }}"
                                            @if ($company->id == old('company_id', $company->id))
                                                selected="selected"
                                            @endif
                                                        >
                                                        {{ $company->name }}
                                                        </option>
                                                    </li>
                                                    @endforeach

                                                </select>

                                                @if ($errors->has('company_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company_name') }}</strong>
                                                    </span>
                                                @endif

                                            </div>

                                        </div>


                                       <div  class="form-group{{ $errors->has('event_map_id') ? ' has-error' : '' }}">

                                            <label for="event_map_id" class="col-sm-3 control-label">
                                            Event Map
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                                <select class="selectpicker form-control"
                                                    name="event_map_id"
                                                    data-style="form-control btn-default btn-outline"
                                                    required>

                                                    @foreach ($ussdeventmaps as $ussdeventmap)
                                                        @if ($ussdeventmap->ussdevent)
                                                            <li class="mb-10">
                                                            <option value="{{ $ussdeventmap->id }}"
                                                                @if ($ussdeventmap->id == old('event_map_id', $ussdeventmap->id))
                                                                    selected="selected"
                                                                @endif
                                                                >
                                                                    {{ $ussdeventmap->ussdevent->name }}  -
                                                                    {{ $ussdeventmap->ussdeventtype->name }}
                                                                </option>
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                </select>

                                                @if ($errors->has('event_map_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('event_map_id') }}</strong>
                                                        </span>
                                                @endif

                                            </div>

                                        </div>


                                        {{-- <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                            <label for="status_id" class="col-sm-3 control-label">
                                            Status
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                                <select class="selectpicker form-control"
                                                    name="status_id"
                                                    data-style="form-control btn-default btn-outline"
                                                    required>

                                                    @foreach ($statuses as $status)
                                                        <li class="mb-10">
                                                            <option value="{{ $status->id }}"
                                                                @if ($status->id == old('status_id', $status->id))
                                                                    selected="selected"
                                                                @endif
                                                                >
                                                                {{ $status->name }}
                                                            </option>
                                                        </li>
                                                    @endforeach

                                                </select>

                                                @if ($errors->has('status_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('status_id') }}</strong>
                                                        </span>
                                                @endif

                                            </div> --}}

                                        </div>


                                       <br/>

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
<script src="{{ asset('myjs/dropify.min.js') }}"></script>
<script src="{{ asset('myjs/form-file-upload-data.js') }}"></script>

@endsection
