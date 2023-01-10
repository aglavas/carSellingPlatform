@component('mail::message')
# Message from emilfrey.carmarket.io

Following message has been sent by {{ $user->email }}:

@component('mail::panel')
{!! $message !!}
@endcomponent

@endcomponent
