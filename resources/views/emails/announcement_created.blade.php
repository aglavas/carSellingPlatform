@component('mail::message')
# {{ $title }}

{!! $content !!}

Best regards,<br>
{{ config('app.name') }}
@endcomponent
