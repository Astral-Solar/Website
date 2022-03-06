@extends('layouts.app')

@section('title', "Permissions")

@section('content')
    @php
        $allGroups = new Group();
        $allGroups = $allGroups->GetAllGroups();
    @endphp

    <h1 class="ui inverted header">Groups</h1>

    <div class="ui divider"></div>

    <h2 class="ui inverted header">Create Group</h2>
    <form action="/admin/permissions/group/create" method="post" enctype="multipart/form-data" class="ui inverted form">
        <div class="two fields">
            <div class="field">
                <label>Display Name</label>
                <input type="text" name="display_name" placeholder="Super Duper Admin">
            </div>

            <div class="field">

                <Label>Identifier (xAdmin name)</Label>
                <input type="text" name="identifier" placeholder="superduperadmin">
            </div>
        </div>

        <button type="submit" value="Submit" class="ui blue fluid button">Submit</button>
    </form>

    <div class="ui divider"></div>

    <h2 class="ui inverted header">Edit Usergroup</h2>
    <form action="/admin/permissions/group/edit" method="post" enctype="multipart/form-data" class="ui inverted form">
        <select name="group" id="group_edit_group">
            @foreach($allGroups as $group)
                <option value="{{  $group->GetIdentifier() }}">{{ $group->GetName() }}</option>
            @endforeach
        </select>

        <div class="two fields">
            <div class="field">
                <label>Display Name</label>
                <input type="text" name="display_name" id="group_edit_name" placeholder="Super Duper Admin">
            </div>

            <div class="field">

                <Label>Identifier (xAdmin name)</Label>
                <input type="text" name="identifier" id="group_edit_identifier" placeholder="superduperadmin">
            </div>
        </div>

        <button type="submit" value="Submit" class="ui blue fluid button">Submit</button>
    </form>
    <script>
        $("#group_edit_group").on('change', function() {
            var groupIdent = this.value;
            var groupName = $("#group_edit_group option:selected").text();

            $("#group_edit_name").val(groupName);
            $("#group_edit_identifier").val(groupIdent);
        });
    </script>

    <div class="ui divider"></div>

    <h2>Group Permissions</h2>
    <form action="/admin/permissions/group/nodes" method="post" class="ui inverted form">
        <h3>Permission Nodes</h3>
        <table class="ui basic inverted celled table">
            <thead>
                <tr>
                    <th>Group</th>
                    @foreach($config->get("Permissions") as $permission)
                        <th>{{ $permission['name'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>

        <button type="submit" value="Submit" class="ui blue fluid button">Submit</button>
    </form>
@endsection