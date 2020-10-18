@component('mail::message')

# Dear {{ $company_user->user->first_name }},

Your loan application of **Ksh {{ $company_user->loan_amount }}** at {{ $company_user->company->name }} has been approved. <br><br>

Your loan repayment breakdown is as follows: <br> 

@component('mail::table')

{!! html_entity_decode($company_user->message) !!} 

@endcomponent

Regards,<br> 

{{ $company_user->company->short_name }} Management

@endcomponent
