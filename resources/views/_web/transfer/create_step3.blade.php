@extends('_web.layouts.master')

@section('title')
    Confirm Transfer Funds -
    @if($transaction_account)
        To {{ getAccountTypeTextTransactionAccount() }}
    @else
        To {{ getAccountTypeTextWalletAccount() }}
    @endif
@endsection

@section('page_title')
    Confirm Transfer Funds -
    @if($transaction_account)
        To {{ getAccountTypeTextTransactionAccount() }}
    @else
        To {{ getAccountTypeTextWalletAccount() }}
    @endif
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
                                <h3>Confirm Transfer Funds -
                                    @if($transaction_account)
                                        To {{ getAccountTypeTextTransactionAccount() }}
                                    @else
                                        To {{ getAccountTypeTextWalletAccount() }}
                                    @endif
                                </h3>
                            </div>

                            <form action="{{ route('my-account.transferfund.create_step2') }}" class="form-box" method="get">

                                {{ csrf_field() }}


                                <div class="md-form mat-2 mx-auto">

                                    @if($transaction_account)
                                        <input type="text" value="{{ $transaction_account->account_no }}" name="account_no" disabled>
                                    @else
                                        <input type="text" value="{{ getAccountTypeTextWalletAccount() }}" name="account_no" disabled>
                                    @endif

                                    <label for="account_no">Destination Account No</label>

                                </div>

                                <div class="md-form mat-2 mx-auto">

                                    @if($transaction_account)
                                        <input type="text"
                                            value="{{ $transaction_account->account_name }}  &nbsp;&nbsp; (Unpaid Balance: {{ $transaction_account->transaction->formatted_transaction_balance }})"
                                            name="account_name" disabled>
                                    @else
                                        <input type="text" value="{{ getAccountTypeTextWalletAccount() }}" name="account_name" disabled>
                                    @endif

                                    <label for="account_name">Account Name</label>

                                </div>

                                <div class="md-form mat-2 mx-auto">

                                    <input type="text" value="{{ formatCurrency(getUserDepositAccountBalance()) }}" name="wallet_balance" disabled>
                                    <label for="wallet_balance">Your Wallet Account Balance</label>

                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('amount') }}" name="amount" id="amount" class="digitsOnly">
                                    <label for="amount" id="label_amount">Enter Transfer Amount</label>

                                    @if ($errors->has('amount'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <button class="btn btn-xs" type="submit">Confirm Transfer</button>
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

        /* $(document).ready(function() {

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

        }); */

    </script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">



@endsection
