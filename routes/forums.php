<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/forums', function ($request, $response) use ($blade, $me, $steam, $config) {

    return $blade->make('page.forums.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/forums/boards/[i:boardID]', function ($request, $response) use ($blade, $me, $steam, $config) {
    $board = new Board($request->boardID);

    if (!$board->exists) {
        $response->code(404);
        $response->send();
        die();
    }
    if (!$me->HasPermission($board->GetID() . ':forums.thread.%')) {
        $response->redirect("/forums", 403);
        $response->send();
        die();
    }

    return $blade->make('page.forums.board', ['me' => $me, 'steam' => $steam, 'config' => $config, 'masterBoard' => $board])->render();
});

$klein->respond('GET', '/forums/boards/[i:boardID]/thread/create', function ($request, $response) use ($blade, $me, $steam, $config) {
    $board = new Board($request->boardID);

    if (!$board->exists) {
        $response->code(404);
        $response->send();
        die();
    }
    if (!$me->HasPermission($board->GetID() . ':forums.thread.write')) {
        $response->code(403);
        $response->send();
        die();
    }

    return $blade->make('page.forums.thread.create', ['me' => $me, 'steam' => $steam, 'config' => $config, 'masterBoard' => $board])->render();
});

$klein->respond('GET', '/forums/threads/[i:threadID]', function ($request, $response) use ($blade, $me, $steam, $config) {
    $thread = new Thread($request->threadID);
    $threadID = $thread->GetBoard()->GetID();

    if (!$thread->exists) {
        $response->code(404);
        $response->send();
        die();
    }

    if (!$me->HasPermission( "$threadID:forums.thread.read")) {
        $response->code(403);
        $response->send();
        die();
    }
    // The thread is deleted and they can't see deleted threads
    if ($thread->IsDeleted() and !$me->HasPermission( "$threadID:forums.thread.delete")) {
        $response->code(403);
        $response->send();
        die();
    }

    return $blade->make('page.forums.thread.view', ['me' => $me, 'steam' => $steam, 'config' => $config, 'thread' => $thread])->render();
});

/*
 * POST
 */
$klein->respond('POST', '/forums/boards/[i:boardID]/thread/create', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    $board = new Board($request->boardID);

    if (!$board->exists) {
        $response->code(404);
        $response->send();
        die();
    }

    if (!$me->HasPermission($board->GetID() . ':forums.thread.write')) {
        $response->code(403);
        $response->send();
        die();
    }

    // Validate Display Name
    $title = isset($_POST['title']) ? $_POST['title'] : false;
    if (!$title or (strlen($title) < 1) or (strlen($title) > 128)) {
        $response->code(400);
        $response->send();
        die();
    }

    // Validate content
    $content = !($_POST['content'] == '{"ops":[{"insert":"\n"}]}') ? $_POST['content'] : false;
    if (!$content) {
        $response->code(402);
        $response->send();
        die();
    }


    $thread = new Thread();
    $thread = $thread->Create($board, $title, $me);

    $post = new ThreadPost();
    $post->Create($thread, $content, $me);

    $response->redirect("/forums/threads/" . $thread->GetID(), 200);
});
$klein->respond('POST', '/forums/threads/[i:threadID]/reply', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    $thread = new Thread($request->threadID);

    if (!$thread->exists) {
        $response->code(404);
        $response->send();
        die();
    }
    if ($thread->IsLocked() or $thread->IsDeleted()) {
        $response->code(403);
        $response->send();
        die();
    }

    // Validate content
    $content = !($_POST['content'] == '{"ops":[{"insert":"\n"}]}') ? $_POST['content'] : false;
    if (!$content) {
        $response->code(402);
        $response->send();
        die();
    }

    $post = new ThreadPost();
    $post->Create($thread, $content, $me);

    $thread->UpdateLastEdited();

    $response->redirect("/forums/threads/" . $thread->GetID(), 200);
});
// Moderation actions
$klein->respond('POST', '/forums/threads/[i:threadID]/lock', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    $thread = new Thread($request->threadID);

    if (!$thread->exists) {
        $response->code(404);
        $response->send();
        die();
    }
    if (!$me->HasPermission($thread->GetID() . ":forums.thread.close")) {
        $response->code(403);
        $response->send();
        die();
    }

    $thread->SetLocked(!$thread->IsLocked());

    $response->redirect("/forums/threads/" . $thread->GetID(), 200);
});
$klein->respond('POST', '/forums/threads/[i:threadID]/pin', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    $thread = new Thread($request->threadID);

    if (!$thread->exists) {
        $response->code(404);
        $response->send();
        die();
    }
    if (!$me->HasPermission($thread->GetID() . ":forums.thread.sticky")) {
        $response->code(403);
        $response->send();
        die();
    }

    $thread->SetPinned(!$thread->IsPinned());

    $response->redirect("/forums/threads/" . $thread->GetID(), 200);
});
$klein->respond('POST', '/forums/threads/[i:threadID]/delete', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    $thread = new Thread($request->threadID);

    if (!$thread->exists) {
        $response->code(404);
        $response->send();
        die();
    }
    if (!$me->HasPermission($thread->GetID() . ":forums.thread.delete")) {
        $response->code(403);
        $response->send();
        die();
    }

    $thread->SetDeleted(!$thread->IsDeleted());

    $response->redirect("/forums/threads/" . $thread->GetID(), 200);
});