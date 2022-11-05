@component('mail::message')
# Welcome

The body of your message.
@component('mail::panel')
The Verification Code :
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
