{{--<ul class="nav-helpers">--}}
{{--@if ($user->canSee('messages'))--}}
{{--<li><i class="icon icon-triangle-left"></i> Dashboard</li>--}}
{{--@endif--}}
{{--@if ($user->canSee('video-center'))--}}
{{--<li><i class="icon icon-triangle-left"></i> Video Center</li>--}}
{{--@endif--}}
{{--@if ($user->canSee('instructional-design'))--}}
{{--<li><i class="icon icon-triangle-left"></i> Instructional Design</li>--}}
{{--@endif--}}
{{--@if ($user->canSee('learning-modules'))--}}
{{--<li><i class="icon icon-triangle-left"></i> Learning Modules</li>--}}
{{--@endif--}}
{{--@if ($user->canSee('resources'))--}}
{{--<li><i class="icon icon-triangle-left"></i> Resources</li>--}}
{{--@endif--}}
{{--@if ($user->canSee('users'))--}}
{{--<li><i class="icon icon-triangle-left"></i> User Management</li>--}}
{{--@endif--}}
{{--</ul>--}}
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar-->
    <section class="sidebar affix">
        <div id="menu" role="navigation">
            <ul class="navigation">
                {{--@if ($user->canSee('messages'))--}}
                    {{--<li>--}}
                        {{--<a href="{{ route ('dashboard') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Home">--}}
                            {{--<i class="menu-icon ti-home"></i>--}}
                            {{--<span class="mm-text ">Home</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="{{ route ('progress-bars.index') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Progress Bars">
                            <i class="menu-icon ti-panel"></i>
                            <span class="mm-text ">My Plan</span>
                        </a>
                    </li>
                {{--@endif--}}
                {{--@if ($user->canSee('video-center'))--}}
                    <li>
                        <a href="{{ route ('video-center.index') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Video Center">
                            <i class="menu-icon ti-video-camera"></i>
                            <span class="mm-text ">Video Center</span>
                        </a>
                    </li>
                {{--@endif
                @if ($user->canSee('instructional-design'))--}}
                {{-- Hidden --}}
                    {{--<li>
                        <a href="{{ route ('instructional-design.index') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Instructional Design">
                            <i class="menu-icon ti-light-bulb"></i>
                            <span class="mm-text ">Instructional Design</span>
                        </a>
                    </li>--}}
                {{--@endif--}}
                {{--@if ($user->canSee('learning-modules'))--}}
                    {{--<li>--}}
                        {{--<a href="{{ route ('learning-modules.index') }}">--}}
                            {{--<i class="menu-icon ti-blackboard"></i>--}}
                            {{--<span class="mm-text ">Learning Modules</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--@endif--}}
                {{--@if ($user->canSee('resources'))--}}
                    <li>
                        <a href="{{ route ('resources') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Docs & Links">
                            <i class="menu-icon ti-agenda"></i>
                            <span class="mm-text">Docs &amp; Links</span>
                        </a>
                    </li>
               {{-- @endif--}}
                {{-- Hidden --}}
                    {{--<li>
                        <a href="/{{ Config::get('chatter.routes.home') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Discussion Board">
                            <i class="menu-icon ti-comments-smiley"></i>
                            <span class="mm-text">Discussion Board</span>
                        </a>
                    </li>--}}
                    <li role="presentation" class="divider"></li>
                    <li>
                        <a href="{{ route ('messages.index') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Messages">
                            <i class="menu-icon ti-comment-alt"></i>
                            <span class="mm-text">Messages</span>
                            {{--@if ($messages->count() > 0)--}}
                                {{--<span class="label label-danger">{{ $messages->count() }}</span>--}}
                            {{--@endif--}}
                        </a>
                    </li>
                    {{-- Hidden --}}
                    {{--<li>
                        <a href="{{ route('activity',['id'=>$user->id]) }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="My Activity">
                            <i class="menu-icon ti-pulse"></i>
                            <span class="mm-text">My Activity</span>
                        </a>
                    </li>--}}
                    {{--<li>--}}
                        {{--<a href="{{ route('profile', ['id' => $user->id ]) }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="My Profile">--}}
                            {{--<i class="menu-icon ti-user"></i>--}}
                            {{--<span class="mm-text">My Profile</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    @if ($user->canSee('users'))
                        {{--<li>
                            <a href="{{ route ('pending-requests') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Pending Requests">
                                <i class="menu-icon ti-hand-open"></i>
                                <span class="mm-text">Pending Requests</span>
                            </a>
                        </li>--}}
                        <li>
                            <a href="{{ route ('users') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Users">
                                <i class="menu-icon ti-id-badge"></i>
                                <span class="mm-text">Users</span>
                            </a>
                        </li>
                    <li>
                        <a href="{{ route ('permissions.index') }}" data-toggle="tooltip" data-tooltip="tooltip" data-placement="right" data-original-title="Permissions">
                            <i class="menu-icon ti-shield"></i>
                            <span class="mm-text">Permissions</span>
                        </a>
                    </li>
                    @endif
                    {{--<li>--}}
                        {{--<a href="{{ route ('faq') }}">--}}
                            {{--<i class="menu-icon ti-info"></i>--}}
                            {{--<span class="mm-text">FAQ</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="{{ route ('help') }}">--}}
                            {{--<i class="menu-icon ti-help"></i>--}}
                            {{--<span class="mm-text">Help</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="{{ route ('report-issue') }}">--}}
                            {{--<i class="menu-icon ti-marker"></i>--}}
                            {{--<span class="mm-text">Report an Issue</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
            </ul>
            <!-- / .navigation -->
        </div>
        <!-- menu -->
    </section>
    <!-- /.sidebar -->
</aside>
