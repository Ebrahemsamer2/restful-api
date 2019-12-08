Hello {{ $user->name }}
Thanks for using our Restful API, Verify your account using this link:
restfulapi.com/users/verify/{{ $user->verification_token }}