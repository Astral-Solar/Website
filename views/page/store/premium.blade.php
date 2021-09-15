@extends('layouts.app')

@section('title', "Premium")
@section('css', '/public/css/settings.css')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>

    <h1>101 reasons to give us money</h1>

    <h2>Reason 1</h2>
    <img src="https://www.cnet.com/a/img/aTLKqWz80LEDLhuX74RcgdKiXMM=/1200x675/2020/02/14/676146ec-f899-4c73-a132-99f7bff87827/vbucks.png">
    <p>I love money. Money is honestly the best thing in the world. Take a look at this cool thing we can do with the money you're going to give us.</p>

    <h2>Reason 2</h2>
    <img src="https://image.shutterstock.com/image-illustration/big-pile-money-american-dollar-260nw-526522342.jpg">
    <p>This is what my bank account will look like after you give me all your money lol.</p>

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