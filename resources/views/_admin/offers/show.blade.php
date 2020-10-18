@extends('_admin.layouts.master')

@section('title')
    Showing Offer - {{ $offer->name }}
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.offers.show', $offer->id) !!}
@endsection


@section('css_header')

    <link href="{{ asset('_admin/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('_admin/css/dropify.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">

            <div class="col-sm-6 col-xs-12">
                <h5 class="txt-dark">Showing Offer - {{ $offer->name }}</h5>
            </div>

            <!-- Breadcrumb -->
            @include('_admin.layouts.partials.breadcrumbs')
            <!-- /Breadcrumb -->

        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">

            <form>

                <div class="col-lg-6 col-xs-12">

                    <div class="panel panel-default card-view  pa-0 equalheight">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body  pa-0">
                                <div class="profile-box">

                                    <div class="social-info">
                                        <div class="row">

                                            <div class="followers-wrap">
                                                <ul class="followers-list-wrap">
                                                    <li class="follow-list">
                                                        <div class="follo-body">

                                                            <div class="follo-data">

                                                                <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                                    <label for="name" class="col-md-4 control-label">
                                                                        Offer Name
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name"
                                                                                name="name" disabled
                                                                                value="{{ $offer->name }}"
                                                                                required
                                                                                autofocus>

                                                                        @if ($errors->has('name'))
                                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                         </span>
                                                                        @endif
                                                                    </div>

                                                                </div>

                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">

                                                                <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                                                    <label for="description" class="col-md-4 control-label">
                                                                        Offer Description
                                                                    </label>
                                                                    <div class="col-md-8">
                                                   <textarea name="description" id="description" rows="3" disabled
                                                             class="form-control">{{ $offer->description }}</textarea>

                                                                        @if ($errors->has('description'))
                                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('description') }}</strong>
                                                         </span>
                                                                        @endif
                                                                    </div>

                                                                </div>

                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">

                                                                <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                                                    <label for="company_id" class="col-md-4 control-label">
                                                                        Establishment
                                                                    </label>
                                                                    <div class="col-md-8">

                                                                        <select class="selectpicker form-control"
                                                                                name="company_id" disabled
                                                                                data-style="form-control btn-default btn-outline"
                                                                                required>

                                                    @foreach ($companies as $company)
                                                        <li class="mb-10">
                                                            <option value="{{ $company->id }}"

                                                                    @if ($company->id == $offer->company_id)
                                                                    selected="selected"
                                                                    @endif
                                                            >
                                                                {{ $company->name }}

                                                            </option>
                                                        </li>
                                                        @endforeach

                                                        </select>

                                                        @if ($errors->has('company_id'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('company_id') }}</strong>
                                                         </span>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group">

                                            <label for="status_id" class="col-md-4 control-label">
                                                Offer Status
                                            </label>
                                            <div class="col-md-8">

                                                <input type="text" class="form-control" disabled name="offer_status" value="{{ $offer->status->name }}">

                                            </div>

                                        </div>

                                        <div class="clearfix"></div>

                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group">
                                            <label for="offer_type" class="col-md-4 control-label">Offer Type</label>
                                            <div class="col-md-8">

                                                <div class="radio no-margin">
                                                    <input type="radio" name="offer_type" value="regular" disabled
                                                           {{ $offer->offer_type=="regular" ? 'checked' : '' }} value="regular">
                                                    <label for="regular">Regular Offer</label>
                                                </div>
                                                <div class="radio no-margin">
                                                    <input type="radio" name="offer_type" value="event" disabled
                                                           {{ $offer->offer_type=="event" ? 'checked' : '' }} value="event">
                                                    <label for="event">Event/ One Time Offer</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group{{ ($errors->has('offer_frequency')) ? ' has-error' : '' }}"
                                        >
                                            <label for="offer_frequency" class="col-sm-4 control-label">Offer Frequency</label>

                                            <div class="col-sm-8">

                                                @if($offer->offer_type == "regular")

                                                    <select class="form-control" name="offer_frequency" disabled>

                                                        <li class="mb-10">
                                                            <option value="recurring-weekly"

                                                                    @if ($offer->offer_frequency == 'recurring-weekly')
                                                                    selected="selected"
                                                                    @endif

                                                            >Weekly</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="recurring-monthly"

                                                                    @if ($offer->offer_frequency == 'recurring-monthly')
                                                                    selected="selected"
                                                                    @endif

                                                            >Monthly</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="recurring-yearly"

                                                                    @if ($offer->offer_frequency == 'recurring-yearly')
                                                                    selected="selected"
                                                                    @endif

                                                            >Yearly</option>
                                                        </li>

                                                    </select>

                                                @endif

                                                @if($offer->offer_type == "event")
                                                    <select class="form-control" name="offer_frequency" disabled>

                                                        <li class="mb-10">
                                                            <option value="once"
                                                                @if ($offer->offer_frequency == 'once')
                                                                    selected="selected"
                                                                @endif
                                                            >Once</option>
                                                        </li>

                                                    </select>
                                                @endif

                                            </div>
                                        </div>

                                        <br><br>

                                        <div  class="form-group">
                                            <label for="offer_day" class="col-sm-4 control-label">Offer Day</label>

                                            <div class="col-sm-8">

                                                <div v-if="offer_type=='regular'">

                                                    <select class="form-control" name="offer_day" v-if="offer_frequency=='recurring-weekly'" disabled>

                                                        <li class="mb-10">
                                                            <option value="monday"

                                                                    @if ($offer->offer_day == 'monday')
                                                                    selected="selected"
                                                                    @endif

                                                            >Monday</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="tuesday"

                                                                    @if ($offer->offer_day == 'tuesday')
                                                                    selected="selected"
                                                                    @endif

                                                            >Tuesday</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="wednesday"

                                                                    @if ($offer->offer_day == 'wednesday')
                                                                    selected="selected"
                                                                    @endif

                                                            >Wednesday</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="thursday"

                                                                    @if ($offer->offer_day == 'thursday')
                                                                    selected="selected"
                                                                    @endif

                                                            >Thursday</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="friday"

                                                                    @if ($offer->offer_day == 'friday')
                                                                    selected="selected"
                                                                    @endif

                                                            >Friday</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="saturday"

                                                                    @if ($offer->offer_day == 'saturday')
                                                                    selected="selected"
                                                                    @endif

                                                            >Saturday</option>
                                                        </li>

                                                        <li class="mb-10">
                                                            <option value="sunday"

                                                                    @if ($offer->offer_day == 'sunday')
                                                                    selected="selected"
                                                                    @endif

                                                            >Sunday</option>
                                                        </li>

                                                    </select>

                                                </div>

                                                @if ($errors->has('offer_day'))
                                                    <span class="help-block">
                                                         <strong>{{ $errors->first('offer_day') }}</strong>
                                                      </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group{{ $errors->has('expiry_at') ? ' has-error' : '' }}">

                                            <label for="expiry_at" class="col-md-4 control-label">
                                                Offer Expiry
                                            </label>
                                            <div class="col-md-8">

                                                <div>
                                                    <input
                                                            type='text'
                                                            class="form-control"
                                                            placeholder="Start Date"
                                                            id='start_date'
                                                            name="expiry_at" disabled
                                                            value="{{ formatFriendlyDate($offer->expiry_at) }}"
                                                />
                                                </div>

                                                @if ($errors->has('expiry_at'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('expiry_at') }}</strong>
                                                         </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group{{ $errors->has('start_at') ? ' has-error' : '' }}">

                                            <label for="start_at" class="col-md-4 control-label">
                                                Offer Start Date
                                                {{-- <span class="text-danger"> *</span> --}}
                                            </label>
                                            <div class="col-md-8">

                                                <div>
                                                    <input
                                                            type='text'
                                                            class="form-control"
                                                            placeholder="Start Date"
                                                            id='start_date'
                                                            name="start_at" disabled
                                                            value="{{ formatFriendlyDate($offer->start_at) }}"
                                                    />
                                                    {{--<span class="input-group-addon">
                                                         <span class="fa fa-calendar"></span>
                                                      </span>--}}
                                                </div>

                                                @if ($errors->has('start_at'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('start_at') }}</strong>
                                                         </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group{{ $errors->has('end_at') ? ' has-error' : '' }}">

                                            <label for="end_at" class="col-md-4 control-label">
                                                Offer End Date
                                                {{-- <span class="text-danger"> *</span> --}}
                                            </label>
                                            <div class="col-md-8">

                                                <div>
                                                    <input
                                                            type='text'
                                                            class="form-control"
                                                            placeholder="Start Date"
                                                            id='end_date'
                                                            name="end_at" disabled
                                                            value="{{ formatFriendlyDate($offer->end_at) }}"
                                                    />
                                                    {{--<span class="input-group-addon">
                                                         <span class="fa fa-calendar"></span>
                                                      </span>--}}
                                                </div>

                                                @if ($errors->has('end_at'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('end_at') }}</strong>
                                                         </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group{{ $errors->has('offer_expiry_method') ? ' has-error' : '' }}">
                                            <label for="offer_expiry_method" class="col-md-4 control-label">Offer Purchase Expiry</label>
                                            <div class="col-md-8">
                                                <div class="radio no-margin">
                                                    <input type="radio" name="offer_expiry_method" value="by_date" disabled
                                                           {{ $offer->offer_expiry_method=="by_date" ? 'checked' : '' }}
                                                           v-model="offer_expiry_method"
                                                           value="by_date"
                                                    >
                                                    <label for="by_date">By Date</label>
                                                </div>
                                                <div class="radio no-margin">
                                                    <input type="radio" name="offer_expiry_method" value="by_sales" disabled
                                                           {{ $offer->offer_expiry_method=="by_sales" ? 'checked' : '' }}
                                                           v-model="offer_expiry_method"
                                                           value="by_sales"
                                                    >
                                                    <label for="by_sales">By Sales</label>
                                                </div>
                                                @if ($errors->has('offer_expiry_method'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('offer_expiry_method') }}</strong>
                                                         </span>
                                                @endif

                                            </div>
                                        </div>

                                        <div  class="form-group{{ $errors->has('by_sales') ? ' has-error' : '' }}"
                                              v-if="offer_expiry_method=='by_sales'">
                                            <label for="by_sales" class="col-md-4 control-label"></label>
                                            <div class="col-md-8 no-gutter">

                                                <label for="max_sales" class="col-md-6 control-label">
                                                    Max No. of drinks
                                                </label>
                                                <div class="col-md-6">
                                                    <input
                                                            type="text"
                                                            class="form-control"
                                                            id="max_sales"
                                                            name="max_sales" disabled
                                                            value="{{ $offer->max_sales }}">

                                                    @if ($errors->has('max_sales'))
                                                        <span class="help-block">
                                                               <strong>{{ $errors->first('max_sales') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                        <div  class="form-group{{ $errors->has('min_age') ? ' has-error' : '' }}">

                                            <label for="min_age" class="col-md-4 control-label">
                                                Restrict By Min Age
                                            </label>
                                            <div class="col-md-8">

                                                <select class="selectpicker form-control"
                                                        name="min_age" disabled
                                                        data-style="form-control btn-default btn-outline"
                                                >

                                                    <li class="mb-10">
                                                        <option value="">None</option>
                                                    </li>

                                                    @foreach ($age_ranges as $age_range)
                                                        <li class="mb-10">
                                                            <option value="{{ $age_range['id'] }}"

                                                                    @if ($age_range['id'] == $offer->min_age)
                                                                    selected="selected"
                                                                    @endif
                                                            >
                                                                {{ $age_range['age'] }}

                                                            </option>
                                                        </li>
                                                    @endforeach

                                                </select>

                                                @if ($errors->has('min_age'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('min_age') }}</strong>
                                                         </span>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                    </div>



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

    <div class="col-lg-6 col-xs-12">
        <div class="panel panel-default card-view pa-0 equalheight">
            <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">

                    <p class="mb-20">
                    <h5>Offer Poster</h5>
                    </p>

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="mt-0">
                                @if($offer->main_image)
                                    <img src="{{ asset($offer->main_image) }}" style="min-height:400px;"  title="{{ $offer->name }}"/>
                                @else
                                    <span class="text-danger">{{ getNoImageText() }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- <p class="mb-20">
                    <h5>Offer Products</h5>
                    </p>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="mt-0">
                                @if(count($offer->offerproducts))

                                    Products Available
                                    @foreach ($offer->offerproducts as $offerproduct)
                                        <li class="mb-10">

                                                {{ $offerproduct->companyproduct->product->name }}

                                        </li>
                                    @endforeach

                                @else
                                    <span class="text-danger">No Offer Products</span>
                                @endif
                            </div>
                        </div>
                    </div> --}}


                    {{-- hhhh --}}

                    <p class="mb-20">
                        <h5><strong>Offer Products</strong></h5>
                    </p>

                    <hr>

                    @if(count($offer->offerproducts))

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="followers-wrap">
                                <ul class="followers-list-wrap">
                                    <li class="follow-list">
                                    <div class="follo-body">

                                        <table class="table table-hover table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th  class="text-right">Normal Price</th>
                                                    <th  class="text-right">Offer Price</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($offer->offerproductsdisplay as $offerproduct)
                                                    <tr>
                                                        <td>{{ $offerproduct->companyproduct->product->name }}</td>
                                                        <td class="text-nowrap" align="right">
                                                            @if ($offerproduct->normal_price)
                                                                {{ formatCurrency($offerproduct->normal_price) }}
                                                            @endif
                                                        </td>
                                                        <td class="text-nowrap" align="right">
                                                            @if ($offerproduct->offer_price)
                                                                {{ formatCurrency($offerproduct->offer_price) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {!! showStatusText($offerproduct->status_id) !!}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.offerproducts.show', $offerproduct->id) }}"
                                                                class="btn btn-info btn-sm btn-icon-anim btn-square"
                                                                title="View Offer">
                                                                <i class="zmdi zmdi-eye"></i>
                                                            </a>

                                                            <a href="{{ route('admin.offerproducts.edit', $offerproduct->id) }}"
                                                                    class="btn btn-primary btn-sm btn-icon-anim btn-square"
                                                                    title="Edit Offer">
                                                                <i class="zmdi zmdi-edit"></i>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    @if (count($offer->offerproducts) > 5)
                                                    <td colspan="5" class="text-rightx">
                                                        <a href="">
                                                           <span> View All Offer Products ({{ count($offer->offerproducts) }})</span>
                                                        </a>
                                                    </td>
                                                    @endif
                                                </tr>

                                            </tbody>
                                        </table>


                                    </div>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>

                    @else

                        <span class="text-danger">No Offer Products</span>

                    @endif

                    {{-- hhhh --}}

                </div>
            </div>
        </div>

    </div>

    <div class="clearfix"></div>

    <div class="col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div  class="panel-body pb-0 ml-20 mr-20">
                    <div class="col-sm-6">
                        <a href="{{ route('admin.offers.edit', $offer->id) }}"
                                class="btn btn-lg btn-info btn-block mt-10 mb-10"
                            >
                            Edit Offer
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.offers.add-products.create', $offer->id) }}"
                                class="btn btn-lg btn-primary btn-block mt-10 mb-10"
                            >
                            Add Offer Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>

    </div>
    <!-- /Row -->

    </div>

@endsection


@section('page_scripts')

    <script type="text/javascript">

        var app = new Vue({
            el: "#app",

            data() {
                return {
                    offer_expiry_method: 'by_date',
                    offer_frequency: 'recurring-weekly',
                    offer_type: 'regular'
                }
            }

        });
    </script>

    <script src="{{ asset('_admin/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('_admin/js/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('_admin/myjs/dropify.min.js') }}"></script>
    <script src="{{ asset('_admin/myjs/form-file-upload-data.js') }}"></script>

    @include('_admin.layouts.partials.error_messages')

    <!-- search scripts -->
    @include('_admin.layouts.searchScripts')
    <!-- /search scripts -->



@endsection

