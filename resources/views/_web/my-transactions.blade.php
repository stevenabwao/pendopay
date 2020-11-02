@extends('_web.layouts.master')

@section('title')

My-transactions

@endsection


@section('content')


<div class="row justify-content-center">
  
  <div class="col-md-3" >
    <div class="card">
      <div class="row justify-content-center form-title">
        <h2>create new transaction</h2>
    </div>
    <hr>
    <div class="md-form mat-2 mx-auto">
      <input type="text" value="{{ old('transaction-title') }}" name="transaction-title" >
      <label for="example">Title of transaction</label>
  </div>
  @if ($errors->has('transaction-title'))
      <div class="help-block">
          <strong>{{ $errors->first('transaction-title') }}</strong>
      </div>
  @endif

  <div>
    <h3>
      Transaction category
     </h3> 
   </div>
   <div class="row justify-content-center">
    <div class="form-check form-check-inline">
      <input type="radio" class="form-check-input"  name="seller">
      <label class="form-check-label" for="materialInline1">Seller</label>
    </div>
    
    <div class="form-check form-check-inline">
      <input type="radio" class="form-check-input"  name="buyer">
      <label class="form-check-label" for="materialInline2">Buyer</label>
    </div>
   </div>
   <div class="md-form mat-2 mx-auto">
    <input type="text" id="amount" value="{{ old('amount') }}" name="amount" >
    <label for="example">Amount or Value of the transaction(ksh)</label>
</div>
@if ($errors->has('amount'))
    <div class="help-block">
        <strong>{{ $errors->first('amount') }}</strong>
    </div>
@endif
<div class="md-form mat-2 mx-auto">
  <input type="text" id="transaction-date" value="{{ old('transaction-date') }}" name="dob" onfocus = "(this.type = 'date')">
  <label class="date"for="example">Transaction due date</label>
</div>
@if ($errors->has('transaction-date'))
  <div class="help-block">
      <strong>{{ $errors->first('transaction-date') }}</strong>
  </div>
@endif
<div>
  <h3>
    Details of transactio patner
   </h3> 
 </div>
 <div class="md-form mat-2 mx-auto">
  <input type="text" id="phone" value="{{ old('phone') }}" name="phone">
  <label for="example">Phone Number</label>
</div>
@if ($errors->has('phone'))
  <div class="help-block">
      <strong>{{ $errors->first('phone') }}</strong>
  </div>
@endif
<div class="md-form mat-2 mx-auto">
  <input type="text" value="{{ old('id_number') }}" name="id_number" >
  <label for="example">ID No/ Passport No</label>
</div>
@if ($errors->has('id_number'))
  <div class="help-block">
      <strong>{{ $errors->first('id_number') }}</strong>
  </div>
@endif
<div class="md-form mat-2 mx-auto">
  <input type="text" id="email" value="{{ old('email') }}" name="email" >
  <label for="example">Email adress</label>
</div>
@if ($errors->has('email'))
  <div class="help-block">
      <strong>{{ $errors->first('email') }}</strong>
  </div>
@endif

<hr>
<div class="inputs row">
  <button class="btn btn-xs" type="submit">Create Transaction</button>
</div>

    </div>

  
  </div>
       <div class="col-md-8" >
             
        <div class="card">
              <div class="row justify-content-center">
                     <div class="col-md-12" >
                            <div class="row justify-content-center form-title">
                                   <h2>Transaction history</h2>
                               </div>
                               <div class="row justify-content-center">
                                 <strong style="align-content: center">completed transactions</strong>
                               </div>
                               <div class="row">

                                 <div class="column">
                                   <i class="fab fa-sellcast" style='font-size:48px;color:rgb(0, 4, 255)'></i>selling a car
                                 
                                 </div>
                                 <div>
                                   <h2>ksh 500,000</h2>
                                 </div>
                               
                              

                               </div>

                                <div class="row justify-content-center">
                                  <strong>Pending transactions</strong>
                                </div>
                                <div class="row justify-content-center">
                                  <strong>Cancelled transactions</strong>
                                </div>
                 </div>
              </div>
        </div>
 <hr>
@endsection


@section('page_css')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">


@endsection
@section('page_scripts')

<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
@endsection