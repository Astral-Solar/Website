<?php
$klein->respond('GET', '/api/users/find', function ($request, $response) use ($blade, $me, $steam, $config, $cache) {
    $search = $_GET['q'];

    if (!isset($search) or ($search == "")) {
        $response->code(400);
        $response->send();
        die();
    }

    $users = new User();
    $users = $users->FindAllByWord($search);

    $results = [
        'total_count' => 0,
        'items' => []
    ];

    foreach($users as $user) {
        array_push($results['items'], [
            'userid' => $user->GetSteamID64(),
            'name' => $user->GetName()
        ]);

        $results['total_count']++;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($results);
});
