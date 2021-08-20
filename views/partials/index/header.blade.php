  <header class="mb-4">
    <div class="content">
      @include('partials.navigation')
      <div class="d-flex justify-content-center m-4">
        <div class="d-flex flex-column">
          <img class="d-block mx-auto rounded-circle m-4" src="{{ $config->get('Domain') }}/public/media/logo.png">
          <h1>{{ $config->get('App Name') }}</h1>
          <p>A little description here.</p>
        </div>
      </div>
    </div>
  </header>
