@extends('layouts.app')

@section('title', "Permissions")

@section('content')
    @php
        $allGroups = new Group();
        $allGroups = $allGroups->GetAllGroups();
    @endphp

    <h1>Permissions</h1>

    <hr/>

    <h2>Create Usergroup</h2>
    <form action="/admin/permissions/group/create" method="post">
        <h3>Display Name</h3>
        <input type="text" name="display_name" placeholder="Super Duper Admin">

        <h3>Identifier (xAdmin name)</h3>
        <input type="text" name="identifier" placeholder="superduperadmin">

        <h3>Submit</h3>
        <button type="submit" value="Submit">Submit</button>
    </form>

    <hr/>

    <h2>Group Permissions</h2>
    <form action="/admin/permissions/nodes" method="post">
        <h3>Permission Nodes</h3>
        <table style="width: 100%">
            <tr>
                <th>Group</th>
                @foreach($config->get("Permissions") as $permission)
                    <th>{{ $permission['name'] }}</th>
                @endforeach
            </tr>
            @foreach($allGroups as $group)
            <tr>
                <td>{{ $group->GetName() }} ({{ $group->GetIdentifier() }})</td>
                @foreach($config->get("Permissions") as $permission)
                    <td>
                        <input type="checkbox" name="{{ $group->GetIdentifier() }}_{{ $permission['node'] }}" {{ $group->HasPermission($permission['node']) ? 'checked' : '' }}>
                    </td>
                @endforeach
            </tr>
            @endforeach
        </table>

        <h3>Submit</h3>
        <button type="submit" value="Submit">Submit</button>
    </form>
@endsection