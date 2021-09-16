@extends('layouts.app')

@section('title', "Premium")
@section('css', '/public/css/settings.css')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>

    <h1>101 reasons to give us money</h1>

    @foreach($config->get('Store Premium Content') as $content)
        <h2>{{ $content['title'] }}</h2>
        @if(isset($content['img']))
            <img src="{{ $content['img'] }}">
        @endif
        <p>{{ $content['desc'] }}</p>
    @endforeach

    <h1>Checkout</h1>
    <p>Here you can buy the cool thing. Just go get your mums credit card and put the numbers in :P</p>

    <div class="checkout-container"></div>

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