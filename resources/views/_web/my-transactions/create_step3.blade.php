@extends('_web.layouts.master')

@section('title')
    Send Transaction Request To {{ titlecase($trans_data->trans_partner_role) }}
@endsection

@section('page_title')
    Send Transaction Request To {{ titlecase($trans_data->trans_partner_role) }}
@endsection

{{-- {{ dd($trans_data) }} --}}

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('my-transactions.create') !!}
@endsection


@section('content')

    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-7" >
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img  class="" src="{{ asset('images/login_icon.png') }}" />
                        <br>
                        <p class="card-text">
                    </div>
                    <div class="row justify-content-center form-title">
                    <h3>Send Transaction Request To {{ titlecase($trans_data->trans_partner_role) }}</h3>
                    </div>
                    <form action="{{ route('my-transactions.store-step3') }}" class="form-box" method="post">

                        {{ csrf_field() }}

                        @if($user_data)

                            <h3>{{ titlecase($trans_data->trans_partner_role) }} Details:</h3>
                            <div class="md-form mat-2 mx-auto">
                                <input type="text" value="{{ $user_data->first_name }} {{ $user_data->last_name }}" disabled>
                                <input type="hidden" value="{{ $user_data->id }}" name="user_id">
                                <input type="hidden" value="{{ $trans_data->trans_partner_role }}" name="trans_partner_role">
                                <input type="hidden" value="{{ $id }}" name="trans_id">
                                <label for="title">User Names</label>
                            </div>

                            <div class="md-form mat-2 mx-auto">
                                <input type="text" value="{{ $user_data->phone }}" disabled>
                                <label for="title">Phone No</label>
                            </div>

                            <div class="md-form mat-2 mx-auto">
                                <input type="text" value="{{ $user_data->email }}" disabled>
                                <label for="title">Email Address</label>
                            </div>
                            <hr>

                        @else

                            <h3 class="text-danger">{{ $error_message }}</h3>
                            <hr>
                            <input type="hidden" value="{{ $trans_data->trans_partner_role }}" name="trans_partner_role">

                            <div class="md-form mat-2 mx-auto radiobtn">
                                <label class="date" for="trans_partner_details">Enter {{ titlecase($trans_data->trans_partner_role) }} Email Address or Phone No. and we will ask them to join Pendopay</label>
                                <div class="row justify-content-center">
                                    <div class="form-check form-check-inline radioform">
                                        <input type="radio" class="form-check-input" value="phone" name="partner_details_select"
                                            {{ old('partner_details_select', 'phone') == 'phone' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="materialInline1">Phone No</label>
                                    </div>
                                    <div class="form-check form-check-inline radioform">
                                        <input type="radio" class="form-check-input" value="email" name="partner_details_select"
                                            {{ old('partner_details_select') == 'email' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="materialInline2">Email Address</label>
                                    </div>

                                </div>
                            </div>

                            <div class="md-form mat-2 mx-auto">
                                <input type="text" value="{{ old('transaction_partner_details') }}" class="form-control" name="transaction_partner_details">
                                <label class="date" for="transaction_partner_details">Enter Details Here</label>
                                <div>
                                    @if ($errors->has('transaction_partner_details'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('transaction_partner_details') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        @endif

                        <div class="inputs row">
                            <button class="btn btn-xs" type="submit">Send Transaction Request</button>
                        </div>

                    </form>

                    </p>
                </div>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('page_scripts')

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

    <script>
        $(document).ready(function(){

            $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            toggleActive: true
            });

        });
    </script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="{{ asset('css/datepicker_custom.css') }}">

@endsection
