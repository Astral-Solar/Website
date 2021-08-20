    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand">
          <img class="d-block mx-auto rounded-circle" src="{{ $config->get('Domain') }}/public/media/logo.png">
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-dropdown">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-dropdown">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ $config->get('Domain') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ $config->get('Domain') }}/forums">Forums</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                style="color: gold; font-weight: bold;">Store</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" onclick="buyCredits()">Buy Credits</a>
                </li>
                <li>
                  <a class="dropdown-item" onclick="giftCredits()">Gift Credits</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Community</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/community/users">Users</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/community/leaderboard">Leaderboard</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/community/staff">Staff</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/community/punishments">Punishments</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/community/rules">Rules</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Social</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/social/steam">Steam</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/social/discord">Discord</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/social/gametracker">Gametracker</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Other</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/commits">Commits</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/legal/termsofservice">Terms Of Service</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ $config->get('Domain') }}/legal/privacypolicy">Privacy Policy</a>
                </li>
              </ul>
            </li>
          </ul>
          <button class="btn btn-outline-light" type="submit">Login</button>
        </div>
      </div>
    </nav>
