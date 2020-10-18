@component('mail::message')

# Dear {{ $company_user->user->first_name }} {{ $company_user->user->last_name }},

Thank you for making repayment of **Ksh {{ $company_user->sum_repayments }}** for your loan at {{ $company_user->company->name }}. <br><br>

Your loan repayment breakdown is as follows: <br>

@component('mail::table')

{!! html_entity_decode($company_user->message) !!} 

@endcomponent

Regards,<br> 

{{ $company_user->company->short_name }} Management

@endcomponent
