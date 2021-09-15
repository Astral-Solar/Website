<header class="mb-4">
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand">
                    <img class="d-block mx-auto rounded-circle" src="{{ $config->get('Domain') }}/public/media/logo.png">
                </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-dropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-dropdown">
                    <div class="navbar-nav me-auto">
                        <a class="nav-item nav-link" href="/">Home</a>
                        <a class="nav-item nav-link" href="/forums">Forums</a>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                               style="color: gold; font-weight: bold;">Store</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/store/premium">Go Premium</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Community</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/community/users">Users</a>
                                <a class="dropdown-item" href="/community/leaderboard">Leaderboard</a>
                                <a class="dropdown-item" href="/community/staff">Staff</a>
                                <a class="dropdown-item" href="/community/punishments">Punishments</a>
                                <a class="dropdown-item" href="/community/rules">Rules</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Social</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/social/steam">Steam</a>
                                <a class="dropdown-item" href="/social/discord">Discord</a>
                                <a class="dropdown-item" href="/social/gametracker">Gametracker</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Other</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/commits">Commits</a>
                                <a class="dropdown-item" href="/legal/termsofservice">Terms Of Service</a>
                                <a class="dropdown-item" href="/legal/privacypolicy">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                    @if($me->exists)
                        <div class="navbar-nav">
                            <div class="nav-item dropdown">
                                <a class="nav-link" data-bs-toggle="dropdown">
                                    <img class="d-block rounded-circle" src="{{ $me->GetAvatar() }}">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/profile/{{ $me->GetSteamID64() }}">My Profile</a>
                                    <a class="dropdown-item" href="/settings">Settings</a>
                                    @if($me->HasPermission('groups.%') or $me->HasPermission('forums.%'))
                                        <a class="dropdown-item" href="/admin">Admin</a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/logout">Logout</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <a class="btn btn-outline-light" href="{{ $steam->loginUrl() }}">Login</a>
                    @endif
                </div>
            </div>
        </nav>
        @yield('header')
    </div>
</header>