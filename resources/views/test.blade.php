@if ( count($users) )
    @foreach ($users as $user)
        <p>user id: {{ var_dump($user) }}, user name: {{ $user->name }}</p>
    @endforeach
@endif