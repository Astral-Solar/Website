<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/store/premium', function ($request, $response) use ($blade, $me, $steam, $config) {
    return $blade->make('page.store.premium', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

/*
 * POST
 */



/*
 * WEBHOOKS
 */

$klein->respond('POST', '/webhook/store/premium', function ($request, $response) use ($blade, $me, $steam, $config) {
    $premium = new Premium();

    $premium->LogRequest($_POST);

    // We check the request is actually coming from Paddle
    if (!$premium->ValidateKey($request->p_signature, $_POST)) {
        $response->code(403);
        $response->send();
        die();
    }

    $passthrough = json_decode($_POST['passthrough'] , true);

    $subscription = new Premium($passthrough['user']);

    $requestType = $_POST['alert_name'];

    // The start of a new subscription
    if (($requestType == "subscription_created") and !$subscription->exists) {
        $subscription = $premium->Create($passthrough['user'], $passthrough['subscriber'], $_POST['cancel_url'], $_POST['update_url'], $_POST['next_bill_date']);

    // User has renewed their subscription for another month. All we need to do is update the next billing date
    } elseif (($requestType == "subscription_payment_succeeded") and $subscription->exists) {
        $subscription->SetStatus($_POST['status']);
        $subscription->SetNextBillDate($_POST['next_bill_date']);
        $subscription->SetActive(true);

    // subscription changed in some way
    } elseif (($requestType == "subscription_updated") and $subscription->exists) {
        $subscription->SetStatus($_POST['status']);
        $subscription->SetNextBillDate($_POST['next_bill_date']);
        // If it's not active then there's something wrong. We should disable it to be safe
        if (!$_POST['status'] == "active") {
            $subscription->SetActive(false);
        }

    // User failed to pay for their subscription. Lol, they're probably poor
    } elseif (($requestType == "subscription_payment_failed") and $subscription->exists) {
        $subscription->SetStatus($_POST['status']);
        $subscription->SetActive(false);

    // A user has ended their subscription
    } elseif (($requestType == "subscription_cancelled") and $subscription->exists) {
        // Their subscription is since over
        $subscription->Delete();
    }

    $response->code(200);
    $response->send();
});
