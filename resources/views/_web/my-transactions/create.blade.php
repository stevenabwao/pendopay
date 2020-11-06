@extends('_web.layouts.master')

@section('title')
    New Transaction
@endsection

@section('page_title')
    {!! getLoggedUser()->first_name !!}
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('my-transactions.create') !!}
@endsection

@section('content')

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
        <h3>Create new transaction</h3>
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

</div>


@endsection
@section('page_css')


<link rel="stylesheet" href="{{ asset('css/login.css') }}">

@endsection
@section('page_scripts')
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>

@endsection
