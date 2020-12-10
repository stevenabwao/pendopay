@extends('_web.layouts.master')

@section('title')
    Transfer Funds
@endsection

@section('page_title')
    Transfer Funds
@endsection

@section('page_breadcrumbs')
    {{-- {!! Breadcrumbs::render('my-account.transferfund.create') !!} --}}
@endsection


@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-7" >

                <div class="card">

                    <div class="card-body">

                        <p class="card-text">

                            <div class="row justify-content-center">
                                <img  class="" src="{{ asset('images/login_icon.png') }}" />
                                <br>
                            </div>
                            <div class="row justify-content-center form-title">
                                <h3>Transfer Funds to a wallet/ transaction account</h3>
                            </div>

                            <form action="{{ route('my-account.transferfund.create_step2') }}" class="form-box" method="get">

                                {{ csrf_field() }}

                                <div class="md-form mat-2 mx-auto radiobtn">

                                    <label class="date" for="destination_account_type">Select destination account</label>
                                    <div class="row justify-content-center">

                                        <div class="form-check form-check-inline radioform">

                                          <input type="radio" id="wallet_account" class="form-check-input" value="{{ getAccountTypeWalletAccount() }}" name="destination_account_type"
                                            {{ (empty(old('destination_account_type')) || old('destination_account_type') == getAccountTypeWalletAccount()) ? 'checked' : '' }}>
                                          <label class="form-check-label" for="materialInline1">Wallet</label>
                                        </div>

                                        <div class="form-check form-check-inline radioform">
                                          <input type="radio" id="transaction_account" class="form-check-input" value="{{ getAccountTypeTransactionAccount() }}"
                                            name="destination_account_type" {{ old('destination_account_type') == getAccountTypeTransactionAccount() ? 'checked' : ''}}>
                                          <label class="form-check-label" for="materialInline2">Transaction Account</label>
                                        </div>

                                    </div>

                                    <div>
                                        @if ($errors->has('destination_account_type'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('destination_account_type') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('destination_account_no') }}" name="destination_account_no" id="destination_account_no" class="digitsOnlyx">
                                    <label for="destination_account_no" id="label_destination_account_no">Enter Wallet Account No/ Phone No</label>

                                    @if ($errors->has('destination_account_no'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('destination_account_no') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <button class="btn btn-xs" type="submit">Transfer</button>
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

    <script>
        // Material Select Initialization
        /* $(document).ready(function() {

            $('.mdb-select').materialSelect();

        }); */

        $(document).ready(function() {

            var clearTextBoxes = function() {
                $("#destination_account_no").val("");
            };

            window.onload = function() {
                $("#wallet_account").on("click", toWallet);
                $("#transaction_account").on("click", toTransaction);
            };

            var toWallet = function() {
                $("#label_destination_account_no").text("Enter Wallet Account No/ Phone No");
                clearTextBoxes();
            };

            var toTransaction = function() {
                $("#label_destination_account_no").text("Enter Transaction Account No");
                clearTextBoxes();
            };

        });

    </script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">



@endsection
