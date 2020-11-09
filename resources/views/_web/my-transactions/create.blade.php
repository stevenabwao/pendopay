@extends('_web.layouts.master')

@section('title')
    Create New Transaction
@endsection

@section('page_title')
    Create New Transaction
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('my-transactions.create') !!}
@endsection


@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6" >

        <div class="card">

            <div class="card-body">

                <div class="row justify-content-center">
                    <img  class="" src="{{ asset('images/login_icon.png') }}" />
                    <br>

                    <p class="card-text">
                    </div>
                    <div class="row justify-content-center form-title">
                        <h3>Create New Transaction</h3>
                    </div>

                    <form action="{{ route('my-transactions.store') }}" class="form-box" method="post">

                        {{ csrf_field() }}

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('title', 'Sale of Furniture') }}" name="title" >
                            <label for="title">Transaction Title</label>

                            @if ($errors->has('title'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('transaction_amount', '30000') }}" name="transaction_amount" >
                            <label for="transaction_amount">Transaction Amount</label>

                            @if ($errors->has('transaction_amount'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('transaction_amount') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('transaction_date', '08-12-2020') }}"
                                class="form-control datepicker" name="transaction_date">
                            <label class="date" for="transaction_date">Expected Final Transaction Date</label>
                            <div>
                                @if ($errors->has('transaction_date'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('transaction_date') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="md-form mat-2 mx-auto radiobtn">

                            <label class="date" for="transaction_role">Your Role In The Transaction</label>
                            <div class="row justify-content-center">

                                <div class="form-check form-check-inline radioform">
                                  <input type="radio" class="form-check-input" value="{{ getTransactionRoleSeller() }}"
                                    checked="checked" name="transaction_role">
                                  <label class="form-check-label" for="materialInline1">Seller</label>
                                </div>

                                <div class="form-check form-check-inline radioform">
                                  <input type="radio" class="form-check-input" value="{{ getTransactionRoleBuyer() }}"
                                    name="transaction_role">
                                  <label class="form-check-label" for="materialInline2">Buyer</label>
                                </div>

                            </div>


                            <div>
                                @if ($errors->has('transaction_role'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('transaction_role') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="inputs mt-2">
                            <div class="form-checkbox">

                                <input id="terms" type="checkbox" name="terms"
                                        {{ old('terms', 'checked') ? 'checked' : '' }}>

                                <label for="terms">I accept terms and coditions</label>
                            </div>

                        </div>

                        <hr>

                        <div class="inputs row">
                            <button class="btn btn-xs" type="submit">Submit</button>
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
