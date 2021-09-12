@extends('layouts.app')

@section('title', "Permissions")

@section('content')
    @php
        $allGroups = new Group();
        $allGroups = $allGroups->GetAllGroups();
    @endphp

    <h1>Groups</h1>

    <hr/>

    <h2>Create Group</h2>
    <form action="/admin/permissions/group/create" method="post">
        <h3>Display Name</h3>
        <input type="text" name="display_name" placeholder="Super Duper Admin">

        <h3>Identifier (xAdmin name)</h3>
        <input type="text" name="identifier" placeholder="superduperadmin">

        <h3>Submit</h3>
        <button type="submit" value="Submit">Submit</button>
    </form>

    <hr/>

    <h2>Edit Usergroup</h2>
    <form action="/admin/permissions/group/edit" method="post">
        <select name="group" id="group_edit_group">
            @foreach($allGroups as $group)
                <option value="{{  $group->GetIdentifier() }}">{{ $group->GetName() }}</option>
            @endforeach
        </select>

        <h3>Display Name</h3>
        <input type="text" name="display_name" id="group_edit_name" placeholder="Super Duper Admin">

        <h3>Identifier (xAdmin name)</h3>
        <input type="text" name="identifier" id="group_edit_identifier" placeholder="superduperadmin">

        <h3>Submit</h3>
        <button type="submit" value="Submit">Submit</button>
    </form>
    <script>
        $("#group_edit_group").on('change', function() {
            var groupIdent = this.value;
            var groupName = $("#group_edit_group option:selected").text();

            $("#group_edit_name").val(groupName);
            $("#group_edit_identifier").val(groupIdent);
        });
    </script>

    <hr/>

    <h2>Group Permissions</h2>
    <form action="/admin/permissions/group/nodes" method="post">
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