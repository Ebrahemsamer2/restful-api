@component('mail::message')
# Hello {{ $user->name }}

Thank you for registering to verify this account you must click this button:

@component('mail::button', ['url' => route('verify', $user->verification_token) ])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent