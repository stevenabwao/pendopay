@extends('_admin.layouts.master')

@section('title')

    Showing Order - {{ $order->id }}

@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.orders.show', $order->id) !!}
@endsection

@section('content')

    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">

            <div class="col-sm-6 col-xs-12">
                <h5 class="txt-dark">Showing Order - {{ $order->id }}</h5>
            </div>

            <!-- Breadcrumb -->
            @include('_admin.layouts.partials.breadcrumbs')
            <!-- /Breadcrumb -->

        </div>
        <!-- /Title -->

        {{--
            "id" => 1
    "total" => "6850.00"
    "club_total" => "6300.00"
    "commission" => "550.00"
    "currency_id" => 1
    "shipping_address_id" => null
    "billing_address_id" => null
    "pickup_product" => null
    "confirmed_by" => null
    "confirmed_at" => null
    "rejected_by" => null
    "rejected_at" => null
    "submitted_at" => "2018-10-10 09:31:09"
    "submitted_by" => null
    "delivered_by" => null
    "delivered_at" => null
    "paid_at" => null
    "payment_id" => null
    "user_id" => 18101
    "company_id" => 11
    "offer_id" => 1128
    "status_id" => 13
    "comments" => null
    "created_by" => 18101
    "created_at" => "2018-10-09 22:57:30"
    "updated_by" => 18101
    "updated_at" => "2018-10-10 09:31:09"
            --}}

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
                                                                        Order ID
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name" disabled
                                                                                value="{{ $order->id }}">
                                                                    </div>

                                                                </div>

                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                                    <label for="description" class="col-md-4 control-label">
                                                                        Offer Name
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        @if ($order->offer)
                                                                            <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name" disabled
                                                                                value="{{ $order->offer->name }}">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                                    <label for="description" class="col-md-4 control-label">
                                                                        Client Name
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        @if ($order->client)
                                                                            <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name" disabled
                                                                                value="{{ $order->client->fullName }}">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                                    <label for="description" class="col-md-4 control-label">
                                                                        Establishment
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        @if ($order->company)
                                                                            <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name" disabled
                                                                                value="{{ $order->company->name }}">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label for="description" class="col-md-4 control-label">
                                                                        Order Total
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        @if ($order->total)
                                                                            <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name" disabled
                                                                                value="{{ formatCurrency($order->total) }}">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label for="description" class="col-md-4 control-label">
                                                                        Order Status
                                                                    </label>
                                                                    <div class="col-md-8">

                                                                        @if ($order->status)
                                                                            {!! showStatusText($order->status_id, "", "", $order->status->name) !!}
                                                                        @endif
                                                                        {{-- @if ($order->total)
                                                                            <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name" disabled
                                                                                value="{{ formatCurrency($order->total) }}">
                                                                        @endif --}}
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">

                                                                <div  class="form-group">

                                                                    <label for="start_at" class="col-md-4 control-label">
                                                                        Order Date
                                                                    </label>
                                                                    <div class="col-md-8">

                                                                        <div>
                                                                            <input
                                                                                    type='text'
                                                                                    class="form-control"
                                                                                    placeholder="Start Date"
                                                                                    id='start_date'
                                                                                    name="start_at" disabled
                                                                                    value="{{ formatFriendlyDate($order->submitted_at) }}"
                                                                            />
                                                                        </div>
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
                                <h5>Order Items</h5>
                                </p>

                                <table class="table table-striped">
                                    <thead>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Item</td>
                                            <td>Qty</td>
                                            <td>Price</td>
                                            <td>Total</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="col-xs-12">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div  class="panel-body pb-0 ml-20 mr-20">

                                <a href="{{ route('admin.orders.edit', $order->id) }}"
                                        class="btn btn-lg btn-info btn-block mt-10 mb-10"
                                    >
                                    Edit Order
                                </a>

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

    @include('_admin.layouts.partials.error_messages')

    <!-- search scripts -->
    @include('_admin.layouts.searchScripts')
    <!-- /search scripts -->



@endsection

