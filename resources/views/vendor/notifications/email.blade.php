@component('mail::message')
# {{ __('messages.verify_email_address') }}

{{ __('messages.verify_message') }}

@component('mail::button', ['url' => $actionUrl])
{{ __('messages.verify_button') }}
@endcomponent

{{ __('messages.no_action_required') }}

{{ __('messages.regards') }},<br>
{{ config('app.name') }}

@slot('subcopy')
{{ __('messages.trouble_subcopy') }} [{{ $actionUrl }}]({{ $actionUrl }})
@endslot
@endcomponent
