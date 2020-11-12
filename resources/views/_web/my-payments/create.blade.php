@extends('_web.layouts.master')

@section('title')
    New Payment
@endsection

@section('page_title')
    Make new payment
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('my-payments.create') !!}
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
                        <h3>Make a payment</h3>
                    </div>

                    <form action="{{ route('my-payments.store') }}" class="form-box" method="post">

                        {{ csrf_field() }}
                        <div class="md-form mat-2 mx-auto">
                            <div class="active-cyan-3 active-cyan-4 mb-4">
                                <input class="form-control" type="text"  aria-label="Search">
                                <label for="email">Enter phone/email making payment to</label>
                            </div>
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('title', 'Sale of Furniture') }}" name="title" >
                            <label for="title">Payment Title</label>

                            @if ($errors->has('title'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="md-form mat-2 mx-auto">
                           <select class="mdb-select md-form" nam>
                              <option value="" disabled selected>Choose your option</option>
                              <option value="1">Pay with Pendopay wallet</option>
                              <option value="2">pay with M-pesa</option>
                            </select>
                            @if ($errors->has('payment_method'))
                            <div class="help-block">
                                <strong>{{ $errors->first('payment_method') }}</strong>
                            </div>
                        @endif
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('payment_amount', '30000') }}" name="payment_amount" >
                            <label for="payment_amount">Amount</label>

                            @if ($errors->has('payment_amount'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('payment_amount') }}</strong>
                                </div>
                            @endif
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
    
    <script>
        // Material Select Initialization
            $(document).ready(function() {
               $('.mdb-select').materialSelect();
             });
    </script>

   
  

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    
   

@endsection
