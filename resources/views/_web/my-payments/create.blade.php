@extends('_web.layouts.master')

@section('title')
    Create New Payment
@endsection

@section('page_title')
    Create New Payment
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('my-payments.create') !!}
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
                        <h3>Create New Payment</h3>
                    </div>

                    <form action="{{ route('my-payments.store') }}" class="form-box" method="post">

                        {{ csrf_field() }}

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('phone', getLoggedUser()->phone) }}" name="phone" >
                            <label for="phone">Phone No</label>

                            @if ($errors->has('phone'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('amount', '5') }}" name="amount" class="digitsOnly">
                            <label for="amount">Amount</label>

                            @if ($errors->has('amount'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <div class="inputs mt-2">

                            <p>
                                Click on "Send Request to Phone" button to generate an MPESA payment request on your phone.
                                Enter your MPESA PIN on your phone to complete the payment.
                                <br>
                                You will get your receipt from MPESA and an email payment confirmation from us.
                            </p>

                        </div>

                        <hr>

                        <div class="inputs row">
                            <button class="btn btn-xs" type="submit">Send Request To Phone</button>
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
