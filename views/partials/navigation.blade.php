
<div class="content">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img class="d-block mx-auto rounded-circle" src="/public/media/logo.jpg" alt="CloneWarsRP">
            </a>
            <button class="navbar-toggler" data-bs-target="#navbar-dropdown" data-bs-toggle="collapse" type="button"
                    aria-controls="navbar-dropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-dropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Forums</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbar-community-dropdown-menu" data-bs-toggle="dropdown"
                           role="button" aria-expanded="false" style="color: gold; font-weight: bold;">
                            Store
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbar-community-dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Buy Credits</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Gift Credits</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbar-community-dropdown-menu" data-bs-toggle="dropdown"
                           role="button" aria-expanded="false">
                            Community
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbar-community-dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Users</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Leaderboard</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Staff</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Punishments</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Rules</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbar-community-dropdown-menu" data-bs-toggle="dropdown"
                           role="button" aria-expanded="false">
                            Social
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbar-community-dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Steam</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Discord</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Gametracker</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbar-community-dropdown-menu" data-bs-toggle="dropdown"
                           role="button" aria-expanded="false">
                            Other
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbar-community-dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Developer Logs</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Terms Of Service</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Privacy Policy</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <button class="btn btn-outline-light" type="submit">Login</button>
            </div>
        </div>
    </nav>
    @yield('header')
</div>
