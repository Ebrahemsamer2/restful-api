Hello {{ $user->name }}
Confirm Your new email
{{ route('verify', $user->verification_token) }}

@component('mail::message')
# Hello {{ $user->name }}

Confirm Your new email by clicking this button:

@component('mail::button', ['url' => route('verify', $user->verification_token) ])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

