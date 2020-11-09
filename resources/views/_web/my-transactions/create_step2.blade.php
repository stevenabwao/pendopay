@extends('_web.layouts.master')

@section('title')
    Create New Transaction
    @if ($trans_data['trans_message'])
     - {{ $trans_data['trans_message'] }}
    @endif
@endsection

@section('page_title')
    Create New Transaction
    @if ($trans_data['trans_message'])
     - {{ $trans_data['trans_message'] }}
    @endif
@endsection

{{-- {{ dd($trans_data) }} --}}

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
                        <h3>Create New Transaction
                            @if ($trans_data['trans_message'])
                            - {{ $trans_data['trans_message'] }}
                            @endif
                        </h3>
                    </div>

                    <form action="{{ route('my-transactions.store') }}" class="form-box" method="post">

                        {{ csrf_field() }}

                        <h3>Transaction summary:</h3>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ $trans_data['title'] }}" name="title" disabled>
                            <label for="title">Transaction Title</label>
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ $trans_data['transaction_amount'] }}" name="transaction_amount" disabled>
                            <label for="transaction_amount">Transaction Amount</label>

                            @if ($errors->has('transaction_amount'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('transaction_amount') }}</strong>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <h3>Enter any of the following:</h3>

                        <div class="md-form mat-2 mx-auto radiobtn">

                            <label class="date" for="enter_details">Select seller/ buyer details to enter</label>
                            <div class="row justify-content-center">

                                <div class="form-check form-check-inline radioform">
                                  <input type="radio" class="form-check-input" value="phone" checked="checked" name="enter_details">
                                  <label class="form-check-label" for="materialInline1">Phone No</label>
                                </div>

                                <div class="form-check form-check-inline radioform">
                                  <input type="radio" class="form-check-input" value="email" name="enter_details">
                                  <label class="form-check-label" for="materialInline2">Email</label>
                                </div>

                                <div class="form-check form-check-inline radioform">
                                  <input type="radio" class="form-check-input" value="id_no" name="enter_details">
                                  <label class="form-check-label" for="materialInline2">National ID No</label>
                                </div>

                            </div>

                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('user_id') }}" class="form-control" name="user_id">
                            <label class="date" for="user_id">Enter Details Here</label>
                            <div>
                                @if ($errors->has('user_id'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('phone') }}"
                                class="form-control" name="phone">
                            <label class="date" for="phone">Enter User Phone</label>
                            <div>
                                @if ($errors->has('phone'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('email') }}"
                                class="form-control datepicker" name="email">
                            <label class="date" for="email">Enter User Email</label>
                            <div>
                                @if ($errors->has('email'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div> --}}

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
