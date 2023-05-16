<p>Hello {{ $user->name }},</p>

<p>You are receiving this email because we received a password reset request for your account.</p>

<p>Please click the following link to reset your password:</p>

<p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>

<p>If you did not request a password reset, no further action is required.</p>
