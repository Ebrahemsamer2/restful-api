Hello {{ $user->name }}
Thank you for registering to verify this account you must go to this link
{{ route('verify', $user->verification_token) }}