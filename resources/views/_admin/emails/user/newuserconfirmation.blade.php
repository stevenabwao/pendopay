@component('mail::message')

# Dear {{ $company_user->user->first_name }}, 



Thank you for your interest to join {{ $company_user->company->name }} <br><br>

Please use this code to confirm your account: <br>

**{{ $company_user->user->code }}** <br><br>

Your signup details are as follows: <br><br>

@component('mail::panel')

Full Name: **{{ $company_user->user->first_name }} {{ $company_user->user->last_name }}** <br>

Email: **{{ $company_user->user->email }}** <br>

Phone: **{{ $company_user->user->phone }}** <br><br>

@endcomponent



Regards,<br>

{{ $company_user->company->short_name }} 

@endcomponent
