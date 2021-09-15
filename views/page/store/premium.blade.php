@extends('layouts.app')

@section('title', "Premium")
@section('css', '/public/css/settings.css')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>

    <main class="container">
        <div class="card m-5">
            <div class="card-body">
                <div class="checkout-container"></div>
            </div>
        </div>
    </main>

    <script type="text/javascript">
        @if ($config->get("Paddle")['sandbox'])
        Paddle.Environment.set('sandbox');
        @endif
        Paddle.Setup({ vendor: {{ $config->get("Paddle")['vendorID'] }} });
        Paddle.Checkout.open({
            method: 'inline',
            product: {{ $config->get("Paddle")['productID'] }},
            allowQuantity: false,
            disableLogout: true,
            frameTarget: 'checkout-container',
            frameInitialHeight: 416,
            frameStyle: 'width:100%; min-width:312px; background-color: transparent; border: none;'
        });
    </script>
@endsection