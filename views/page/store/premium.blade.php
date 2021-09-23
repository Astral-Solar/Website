@extends('layouts.app')

@section('title', "Premium")

@section('content')
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>

    @php
        $receiverID = $_GET['receiver'] ?? $me->GetSteamID64();
        $receiver = new User($receiverID);
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
        @if($receiver->GetSubscription())
            <div class="ui inverted negative message">
                <div class="header">
                    {{ $receiver->GetName() }} already has an active subscription!
                </div>
                <p>You cannot purchase a subscription for this user as they already have one!</p>
            </div>
        @endif
        <p>Start a new monthly subscription for Premium. This membership is 5 GBP a month and can be cancelled at <b>any time</b>.</p>

        <div class="ui divider"></div>

        <h1 class="ui header">Total: £5/month
            <div class="sub header">
                Purchasing for:
                <img class="ui avatar image" src="{{ $receiver->GetAvatar() }}">
                <a id="purchase-user" target="_blank" data-steamid="{{ $receiver->GetSteamID64() }}" href="/profile/{{ $receiver->GetSteamID64() }}">{{ $receiver->GetName() }} ({{ $receiver->GetSteamID64() }})</a>
            </div>
        </h1>

        <p>Cancel any time, simply come back to this page and you can manage your subscriptions! There is no cancel fee, and you get to keep your Premium perks till the end of your expected subscription period. (If you subscribed on the 2nd and cancelled on the 12th, you would keep your subscription perks till the 2nd of the following month)</p>

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
    <a class="fluid ui {{ $receiver->GetSubscription() ? 'red' :'green' }} animated fade attached bottom button" tabindex="0" id="open-checkout">
        <div class="visible content">{{ $receiver->GetSubscription() ? 'This user already has a subscription!' :'Purchase for £5/month' }}</div>
        <div class="hidden content">
            <i class="{{ $receiver->GetSubscription() ? 'hand paper' :'shop' }} icon"></i>
        </div>
    </a>

    @if($me->GetMaintainedSubscriptions())
        <h1>Manage your existing subscriptions</h1>
        <table class="ui single line inverted table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Status</th>
                    <th>Started (D/M/Y)</th>
                    <th>Next Bill (D/M/Y)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($me->GetMaintainedSubscriptions() as $sub)
                    <tr>
                        <td>{{ $sub->GetUser()->GetName() }}</td>
                        <td>{{ ucwords($sub->GetStatus()) }}</td>
                        <td>{{ gmdate("d/m/Y", $sub->GetStarted()) }}</td>
                        <td>{{ gmdate("d/m/Y", $sub->GetNextBillDate()) }}</td>
                        <td>
                            <a class="ui orange basic button" href="{{ $sub->GetUpdateURL() }}">Edit</a>
                            <a class="ui pink basic button" href="{{ $sub->GetCancelURL() }}">Cancel</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    <script type="text/javascript">
        @if ($config->get("Paddle")['sandbox'])
        Paddle.Environment.set('sandbox');
        @endif
        Paddle.Setup({ vendor: {{ $config->get("Paddle")['vendorID'] }} });

        function openCheckout() {
            // if(!$('tos_agree'))
            @if($receiver->GetSubscription())
            if (true) return;
            @endif

            if(!$('#tos_agree').is(':checked')) return;
            if(!$('#pp_agree').is(':checked')) return;

            Paddle.Checkout.open({
                product: {{ $config->get('Paddle')['productID'] }},
                passthrough: '{!! json_encode(['subscriber' => $me->GetSteamID64(), 'user' => $receiver->GetSteamID64()]) !!}'
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