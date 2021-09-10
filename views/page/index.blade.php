@extends('layouts.app')

@section('title', 'Home')
@section('css', '/public/css/index.css')

@section('header')
  @include('partials.index.header')
@endsection

@section('content')
<section class="statistics">
  <div class="d-flex justify-content-center m-2">
    <h1>Statistics</h1>
  </div>
  <div class="row d-flex justify-content-center">
    <div class="col-lg-4 mb-4">
      <div class="card text-center">
        <div class="card-body">
          <h1 class="card-title">
            0
          </h1>
          <p class="card-text">
            Statistics 1
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4">
      <div class="card text-center">
        <div class="card-body">
          <h1 class="card-title">
            0
          </h1>
          <p class="card-text">
            Statistics 2
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4">
      <div class="card text-center">
        <div class="card-body">
          <h1 class="card-title">
            0
          </h1>
          <p class="card-text">
            Statistics 3
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="servers">
  <div class="d-flex justify-content-center m-2">
    <h1>Servers</h1>
  </div>
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">Server Name</h5>
      <div class="card-subtitle mb-2">Players: 0/0 | Map: map_here | IP: ip_here</div>
      <p class="card-text">Description about the server</p>
      <div class="progress mb-3">
        <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">25%</div>
      </div>
      <div class="d-grid">
        <button type="button" class="btn btn-primary">Join Server</button>
      </div>
    </div>
  </div>
</section>
@endsection