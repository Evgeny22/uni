<div class="participants full">

    <span class="small-text"><strong>Participants</strong></span>

    <ul class="participants-list">

        @foreach ($participants as $participant)

            <li class="participant">

                <div class="profile-pic">

                    <img src="{{ $participant->avatar->url() }}" alt="{{ $participant->displayName }}" title="{{ empty($participant->nickname) ? "" : "\"$participant->nickname\"" }} {{ $participant->name }}">

                </div>

            </li>

        @endforeach

    </ul>

</div>
