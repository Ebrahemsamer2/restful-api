Hello {{ $user->name }}
You've updated your email, Verify your new account using this link:
restfulapi.com/users/verify/{{ $user->verification_token }}