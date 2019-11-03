<p>Hi,</p>

<p>{{ $invite->user->name }} invited you to collaborate on a Lancer project.</p>

<a href="{{ url('register') }}/{{ $invite->token }}">Click here</a> to register and start collaborating!