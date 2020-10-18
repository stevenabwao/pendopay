@component('mail::message')

# Dear {{ $company_user->user->first_name }}, 

Welcome and thank you for expressing your interest in joining {{ $company_user->company->name }}. <br><br>

Please pay the Entrance Fee of : {{ $company_user->registration_amount }} to {{ $company_user->company->short_name }} Mpesa Paybill No.
{{ $company_user->mpesa_paybill }} A/C No: {{ $company_user->user_phone }}, to complete your registration. <br><br>

@if ($company_user->has_attachments)
Registration forms are attached herein. <br><br>
@endif

Your signup details are as follows: <br><br>

@component('mail::panel')

Full Name: **{{ $company_user->user->first_name }} {{ $company_user->user->last_name }}** <br>

Email: **{{ $company_user->user->email }}** <br>

Phone: **{{ $company_user->user->phone }}** <br><br>

@endcomponent 


Regards,<br>

{{ $company_user->company->short_name }} Management

@endcomponent
