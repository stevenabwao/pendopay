@extends('_web.layouts.master')

@section('title')
    Accept Transaction Request
    {{-- @if ($transaction_data['trans_message'])
     - {{ $transaction_data['trans_message'] }}
    @endif --}}
@endsection

@section('page_title')
    Accept Transaction Request
    {{-- @if ($transaction_data['trans_message'])
     - {{ $transaction_data['trans_message'] }}
    @endif --}}
@endsection

{{-- {{ dd($transaction_data) }} --}}

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
                    </div>

                    <p class="card-text">

                        <div class="row justify-content-center form-title">
                            <h3>Accept Transaction Request
                                {{-- @if ($transaction_data['trans_message'])
                                - {{ $transaction_data['trans_message'] }}
                                @endif --}}
                            </h3>
                        </div>

                        @if(($transaction_data->error_msg) || (session('success')))

                            <div class="alert alert-danger text-center">
                                {{ $transaction_data->error_msg ? $transaction_data->error_msg : (session('success')) }}
                            </div>

                        @else

                            <form action="{{ route('transaction-requests.accept.store', ['token' => $token]) }}" class="form-box" method="post">

                                {{ csrf_field() }}

                                {{-- {{ dd($transaction_data) }} --}}

                                <h3>Transaction summary:</h3>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ $transaction_data->creator->full_name }} - {{ $transaction_data->creator->phone }}" name="title" disabled>
                                    <label for="title">Transaction Creator</label>
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ $transaction_data->title }}" name="title" disabled>
                                    <input type="hidden" value="{{ $transaction_data['id'] }}" name="transaction_id">
                                    <input type="hidden" value="{{ $transaction_request_data['id'] }}" name="transaction_request_id">
                                    <label for="title">Transaction Title</label>
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ formatCurrency($transaction_data['transaction_amount']) }}" name="transaction_amount" disabled>
                                    <label for="transaction_amount">Transaction Amount</label>
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ $transaction_data->trans_role }}" name="trans_role" disabled>
                                    <label for="transaction_amount">Your Role in Transaction</label>
                                </div>

                                <div class="inputs mt-2">

                                    <div class="form-checkbox">

                                        <input id="terms" type="checkbox" name="terms"
                                                {{ old('terms', 'checked') ? '' : '' }}>

                                        <label for="terms">I accept
                                            <a id="scroll-box-trigger" href="#scroll-box" title="Click to view terms and conditions"
                                                class="lightbox full-width" data-lightbox-anima="fade-in">
                                                transaction terms and conditions
                                            </a>
                                        </label>
                                    </div>

                                    {{-- scrollbox --}}
                                    <div id="scroll-box" class="box-lightbox">
                                        <div class="scroll-box" data-height="400" data-rail-color="#c3dff7" data-bar-color="#379cf4">

                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                <img  class="" src="{{ asset('images/login_icon.png') }}" height="30"/> &nbsp;&nbsp;
                                                Transaction Terms and Conditions
                                            </h5>
                                            <hr>

                                            <p>
                                                {!! $terms_and_conditions !!}
                                            </p>

                                        </div>
                                    </div>
                                    {{-- scrollbox --}}

                                </div>

                                <hr>

                                <div class="inputs row">
                                    <div class="col-sm-6">
                                        <button class="btn btn-xs" name="submit_btn" type="submit" value="accept">Accept</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-xs btn-danger" name="submit_btn" type="submit" value="reject">Reject</button>
                                    </div>
                                </div>

                            </form>

                        @endif

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

    <script src="{{ asset('js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/slimscroll.min.js') }}"></script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="{{ asset('css/datepicker_custom.css') }}">

@endsection
