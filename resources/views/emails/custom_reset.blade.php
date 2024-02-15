@component('mail::message')
# {{ __('messages.password_reset_subject') }}

{{ __('messages.password_reset_greeting') }}

{{ __('messages.password_reset_intro') }}

@component('mail::button', ['url' => url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false))])
{{ __('messages.password_reset_button') }}
@endcomponent

{{ __('messages.password_reset_expire') }}

{{ __('messages.password_reset_regards') }} {{ config('app.name') }}

@slot('subcopy')
{{ __('messages.password_reset_subcopy') }}
<a href="{{ url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], true)) }}">
    {{ url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], true)) }}
</a>
@endslot
@endcomponent
