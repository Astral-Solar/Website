@extends('layouts.app')

@section('title', "Permissions")

@section('content')
    @php
        $allBoards = new Board();
        $allBoards = $allBoards->GetAll();
        $allGroups = new Group();
        $allGroups = $allGroups->GetAllGroups();
    @endphp

    <h1>Forums</h1>

    <hr/>

    <h2>Create Board</h2>
    <form action="/admin/forums/board/create" method="post">
        <h3>Display Name</h3>
        <input type="text" name="display_name" placeholder="General Discussion">

        <h3>Description</h3>
        <input type="text" name="description" placeholder="A place for everyone to hang out!">

        <h3>Parent Board</h3>
        <select name="parent">
            <option value="">None</option>
            @foreach($allBoards as $board)
                <option value="{{ $board->GetID() }}">{{ $board->GetName() }}</option>
            @endforeach
        </select>

        <h3>Submit</h3>
        <button type="submit" value="Submit">Submit</button>
    </form>

    <hr/>

    <h2>Board Permissions</h2>
    @foreach($allBoards as $board)
        <h3>{{ $board->GetBreadCrumbAsString() }}{{ $board->GetName() }}</h3>
        <h4>{{ $board->GetDescription() }}</h4>
        <form action="/admin/forums/board/permissions" method="post">
            <input type="hidden" name="boardID" value="{{ $board->GetID() }}">
            <table style="width: 100%">
                <tr>
                    <th>Group</th>
                    @foreach($config->get("Forum Thread Permissions") as $permission)
                        <th>{{ $permission['name'] }}</th>
                    @endforeach
                </tr>
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
            </table>

            <button type="submit" value="Submit">Submit</button>
        </form>
        <br>
    @endforeach

@endsection