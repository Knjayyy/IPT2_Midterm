<p>
    Greetings!  {{$user->name}}.
</p>
<p>
    Email received. This is your verification notif.
</p>
<p>
    Verify account. CLICK HERE.
</p>
<p>
    <a href="{{url('/verification/' . $user->id. '/' . $user->remember_token) }}">Click me harder daddy!</a>
</p>
