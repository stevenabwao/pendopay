@component('mail::message')


@if ($contact->send_to_user)
# Dear {{ $contact->name }},

Thank you for sending us your feedback at {{ $contact->company_website }}. <br><br>Your message details below:<br><br>
@endif

@if ($contact->send_to_admin)
# Dear {{ $contact->company_name_title }},

You have received a new message from the user below on {{ $contact->company_website }}:<br><br>
@endif


@component('mail::panel')

Subject: **{{ $contact->subject }}** <br>

Full Name: **{{ $contact->name }}** <br>

Email: **{{ $contact->email }}** <br>

Phone: **{{ $contact->phone }}** <br>

**Message:** <br>{{ $contact->message }} <br><br>

@endcomponent


Regards,<br>

{{ $contact->company_name_title }} Management

@endcomponent
