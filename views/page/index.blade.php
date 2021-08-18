@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4 mb-4">
            <div class="card text-center">
                <div class="card-body" style="background-color: #0f1010; color: #ffffff">
                    <h1 class="card-title">
                        0
                    </h1>
                    <p class="card-text">
                        Online Members
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card text-center">
                <div class="card-body" style="background-color: #0f1010; color: #ffffff">
                    <h1 class="card-title">
                        0
                    </h1>
                    <p class="card-text">
                        Total Members
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card text-center">
                <div class="card-body" style="background-color: #0f1010; color: #ffffff">
                    <h1 class="card-title">
                        1
                    </h1>
                    <p class="card-text">
                        Total Discord Members
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header')
    <div class="d-flex justify-content-center m-4">
        <div class="d-flex flex-column">
            <img class="d-block mx-auto rounded-circle m-4" src="public/media/logo.jpg">
            <h1>CloneWarsRP</h1>
            <p>A little description here.</p>
        </div>
    </div>
@endsection