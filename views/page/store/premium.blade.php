@extends('layouts.app')

@section('title', "Premium")

@section('content')
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>

    @php
        $recieverID = $_GET['receiver'] ?? $me->GetSteamID64();
        $reciever = new User($recieverID);
    @endphp

    <h2 class="ui top attached inverted dark header">
        Premium Perks
    </h2>

    @foreach($config->get('Store Premium Content') as $key => $content)
        @php
            $rightAlign = (($key % 2) == 1);
        @endphp
        <div class="ui horizontal inverted dark card" style="width: 100%;">
            @if(isset($content['img']) and !$rightAlign)
                <div class="image">
                    <img src="{{ $content['img'] }}">
                </div>
            @endif
            <div class="content" style="border-top: none; @if($rightAlign) text-align: right; @endif">
                <div class="header">{{ $content['title'] }}</div>
                <div class="description">
                    <p>{{ $content['desc'] }}</p>
                </div>
            </div>
            @if(isset($content['img']) and $rightAlign)
                <div class="image">
                    <img src="{{ $content['img'] }}">
                </div>
            @endif
        </div>
    @endforeach

    <h2 class="ui top attached inverted dark header">
        Start a new subscription
    </h2>
    <div class="ui attached inverted dark segment">
        <p>Start a new monthly subscription for Premium. This membership is 5 GBP a month and can be cancelled at <b>any time</b>.</p>

        <div class="ui divider"></div>

        <h1 class="ui header">Total: £5/month
            <div class="sub header">
                Purchasing for:
                <img class="ui avatar image" src="{{ $reciever->GetAvatar() }}">
                <a id="purchase-user" target="_blank" data-steamid="{{ $reciever->GetSteamID64() }}" href="/profile/{{ $reciever->GetSteamID64() }}">{{ $reciever->GetName() }} ({{ $reciever->GetSteamID64() }})</a>
            </div>
        </h1>

        <p>Cancel any time, simply come back to this page and you can manage your subscriptions! There is no cancel fee, and you get to keep your Premium perks till the end of your expected subscription time.</p>

        <div class="ui divider"></div>

        <div>Purchase for someone else</div>
        <div id="receiver_search" class="ui search">
            <div class="ui icon  input">
                <input class="prompt" type="text" placeholder="Search a user">
                <i class="search icon"></i>
            </div>
            <div class="results"></div>
        </div>

        <div class="ui divider"></div>

        <div class="ui inverted relaxed list">
            <div class="item">
                <div class="ui inverted checkbox">
                    <input type="checkbox" id="tos_agree">
                    <label>I agree to the <a href="/store/tos">Terms of Service</a>.</label>
                </div>
            </div>
            <div class="item">
                <div class="ui inverted checkbox">
                    <input type="checkbox" id="pp_agree">
                    <label>I agree to the <a href="/store/pp">Privacy Policy</a>.</label>
                </div>
            </div>
        </div>
    </div>
    <a class="fluid ui green animated fade attached bottom button" tabindex="0"  href="#!" id="open-checkout">
        <div class="visible content">Purchase for £5/month</div>
        <div class="hidden content">
            <i class="shop icon icon"></i>
        </div>
    </a>

    <h1>Manage your existing subscriptions</h1>
    <table class="ui single line inverted table">
        <thead>
            <tr>
                <th>User</th>
                <th>Status</th>
                <th>Started</th>
                <th>Next Bill</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($me->GetMaintainedSubscriptions() as $subs)
                <tr>
                    <td>{{ $subs->GetUser()->GetName() }}</td>
                    <td>{{ ucwords($subs->GetStatus()) }}</td>
                    <td>{{ $subs->GetStarted() }}</td>
                    <td>{{ $subs->GetNextBillDate() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <script type="text/javascript">
        @if ($config->get("Paddle")['sandbox'])
        Paddle.Environment.set('sandbox');
        @endif
        Paddle.Setup({ vendor: {{ $config->get("Paddle")['vendorID'] }} });

        function openCheckout() {
            // if(!$('tos_agree'))

            if(!$('#tos_agree').is(':checked')) return;
            if(!$('#pp_agree').is(':checked')) return;

            Paddle.Checkout.open({
                product: {{ $config->get('Paddle')['productID'] }},
                passthrough: '{!! json_encode(['subscriber' => $me->GetSteamID64(), 'user' => $reciever->GetSteamID64()]) !!}'
            });
        }
        document.getElementById('open-checkout').addEventListener('click', openCheckout, false)


        $('#receiver_search')
            .search({
                apiSettings: {
                    url: '{{ $config->get('Domain') }}/api/users/find?q={query}'
                },
                fields: {
                    results : 'items',
                    title   : 'name'
                },
                minCharacters : 3,
                onSelect: function (result, response) {
                    let url = window.location.href;
                    if (url.indexOf('?') > -1){
                        url += ('&receiver=' + result.userid)
                    }else{
                        url += ('?receiver=' + result.userid)
                    }
                    window.location.href = url;
                }
            })
        ;
    </script>
@endsection