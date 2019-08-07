Hello {{ $user->name }}
Confirm Your new email
{{ route('verify', $user->verification_token) }}