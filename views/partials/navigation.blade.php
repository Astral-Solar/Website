<div class="ui inverted stackable borderless menu navbar">
    <div class="item">
        <img src="/public/media/logo.png">
    </div>
    <a class="item" href="/">Home</a>
    <a class="item" href="/forums">Forums</a>
    <div class="ui inverted dropdown item">
        Store <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="/store/premium">Go Premium</a>
        </div>
    </div>
    <a class="item" href="/members">Members</a>


    <div class="right menu">
        @if($me->exists)
            <div class="ui inverted dropdown item">
                <img class="ui mini avatar image" src="{{ $me->GetAvatar() }}">
                <div class="menu">
                    <a class="item" href="/profile/{{ $me->GetSteamID64() }}">My Profile</a>
                    <a class="item" href="/settings">Settings</a>
                    @if($me->HasPermission('group,%') or $me->HasPermission('forums.%'))
                        <a class="item" href="/admin">Admin</a>
                    @endif
                    <div class="divider"></div>
                    <a class="item" href="/logout">Logout</a>
                </div>
            </div>
        @else
            <div class="item">
                <a class="ui inverted button" href="{{ $steam->loginUrl() }}">Login</a>
            </div>
        @endif
    </div>
</div>

@yield('header')

<script>
    $('.ui.dropdown')
        .dropdown()
    ;
</script>