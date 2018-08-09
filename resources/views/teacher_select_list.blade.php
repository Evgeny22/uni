<ul class="teacher-list">
@foreach ($list as $teacher)

    <li>
        <div><input class="toggle-teacher" type="checkbox" checked id="{{ $teacher['id'] }}"><label for="{{ $teacher['id'] }}"><span></span></label></div>
        <div class="profile-pic"><img src="{{ app('request')->root() }}/img/profiles/{{ $teacher['avatar'] }}.jpg" alt="{{ $teacher['name'] }}"></div>
        <div>{{ $teacher['name'] }}</div>
        <div>{{ $teacher['email'] }}</div>
    </li>

@endforeach
</ul>
