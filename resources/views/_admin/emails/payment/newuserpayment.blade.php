@component('mail::message')

# Dear {{ $payment->account->companyuser->user->first_name }},

Deposit of **Ksh {{ $payment->amount }}** has been made to your account at {{ $payment->account->companyuser->company->name }} via paybill no. {{ $payment->paybill_number }}. <br><br>

Payment details are as follows: <br><br>

@component('mail::panel')

Sender Full Name: **{{ $payment->full_name }}** <br>

Sender Phone: **{{ $payment->phone }}** <br>

Amount: **Ksh {{ $payment->amount }}** <br>

Your Account Name: **{{ $payment->account_name }}** <br><br>

@endcomponent


Regards,<br>

{{ $payment->account->companyuser->company->short_name }} Management

@endcomponent
