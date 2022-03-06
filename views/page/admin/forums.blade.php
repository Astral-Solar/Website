@extends('layou      ts.app')

@section('title', "Permissions")

@section('content')
    @php
        $allBoards = new Board();
        $allBoards = $allBoards->GetAll();
        $allGroups = new Group();
        $allGroups = $allGroups->GetAllGroups();
    @endphp

    <h1 class="ui inverted header">Forums</h1>

    <div class="ui divider"></div>

    <h2 class="ui inverted header">Create Board</h2>
    <form action="/admin/forums/board/create" method="post" enctype="multipart/form-data" class="ui inverted form">
        <div class="field">
            <label>Display Name</label>
            <input type="text" name="display_name" placeholder="General Discussion">
        </div>

        <div class="field">
            <label>Description</label>
            <input type="text" name="description" placeholder="A place for everyone to hang out!">
        </div>

        <div class="two fields">
            <div class="field">
                <label>Parent Board</label>
                <select name="parent">
                    <option value="">None</option>
                    @foreach($allBoards as $board)
                        <option value="{{ $board->GetID() }}">{{ $board->GetName() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Background</label>
                <input type="file" name="background" accept="image/png, image/jpeg">
            </div>
        </div>

        <button type="submit" value="Submit" class="ui blue fluid button">Submit</button>
    </form>

    <div class="ui divider"></div>

    <h2 class="ui inverted header">Board Permissions</h2>
    @foreach($allBoards as $board)
        <h3 class="ui inverted header">
            {{ $board->GetBreadCrumbAsString() }}{{ $board->GetName() }}
            <div class="sub header">{{ $board->GetDescription() }}</div>
        </h3>
        <form action="/admin/forums/board/permissions" method="post">
            <input type="hidden" name="boardID" value="{{ $board->GetID() }}">
            <table class="ui basic inverted celled table">
                <thead>
                    <tr>
                        <th>User Group</th>
                        @foreach($config->get("Forum Thread Permissions") as $permission)
                            <th>{{ $permission['name'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($allGroups as $group)
                        <tr>
                            <td>{{ $group->GetName() }} ({{ $group->GetIdentifier() }})</td>
                            @foreach($config->get("Forum Thread Permissions") as $permission)
                                <td>
                                    <input type="checkbox" name="{{ $group->GetIdentifier() }}_{{ $permission['node'] }}" {{ $group->HasPermission($board->GetID() . ":" . $permission['node']) ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" value="Submit" class="ui orange fluid button">Submit</button>
        </form>
        <br>
    @endforeach

@endsection