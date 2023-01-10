@component('mail::message')
# New Car List has been uploaded

User {{ auth()->user()->email }} uploaded a new list:

@component('mail::button', ['url' => config('app.url').Storage::url($list_data['file_path'])])
Download the List
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
