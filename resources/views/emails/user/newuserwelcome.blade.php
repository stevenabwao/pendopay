@component('mail::message')
# Welcone {{ $company_user->user->first_name }},

Your account has been successfully accepted on {{ $company_user->company->name }}. <br>

Below are your company_user->user account details:<br><br>

@component('mail::panel')
Full Names: {{ $company_user->user->first_name }} {{ $company_user->user->last_name }} <br>

Email address: {{ $company_user->user->email }} <br>

Phone Number: {{ $company_user->user->phone }} <br>

Savings Account No: {{ $company_user->user->phone }} <br><br>
@endcomponent

Please pay a registration fee of **{{ $company_user->user->phone }}** to start making your investments.<br><br>

Thanks,<br>
{{ $company_user->company->name }}
@endcomponent 
