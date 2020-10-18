@component('mail::message')

{!! html_entity_decode($emailqueue->email_salutation) !!}

{!! html_entity_decode($emailqueue->email_text) !!}

@if ($emailqueue->table_text)

@component('mail::table')

{!! html_entity_decode($emailqueue->table_text) !!} 

@endcomponent

@endif

@if ($emailqueue->panel_text)

@component('mail::panel') 

{!! html_entity_decode($emailqueue->panel_text) !!} 

@endcomponent

@endif

{!! html_entity_decode($emailqueue->email_footer) !!}

@endcomponent
