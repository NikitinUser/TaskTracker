@extends('layouts.app')

@section('content')
<div class="row me-5 ms-5">
    <div class="card col-md-12 p-3 justify-content-center">
        <div class="d-flex">
            <div class="mb-3 me-3">
                <a href="getPageAddRole" class="btn btn-primary">Добавить роль</a>
            </div>
            <div class="mb-3">
                <a href="getPageAddPermission" class="btn btn-primary">Добавить право</a>
            </div>
        </div>
        

        <table class="table table-striped" id="roles-permissions-table">
            <th style="width: 150px; !important">Роли\Права</th>
            @foreach ($data['permissions'] as $key => $value)
                <th style="width: 100px; !important"> 
                    <a href="getPageEditPermission?permission_id={{ $value?->id}}">{{ $value?->permission_name}}</a>
                </th>
            @endforeach

            @foreach ($data['roles'] as $key => $role)
                <tr>
                    <td>
                        <a href="getPageEditRole?role_id={{$role?->id}}">{{ $role->role_name}}</a>
                    </td>

                    @foreach ($data['permissions'] as $key => $permission)
                        @php
                            $checked = false;
                        @endphp

                        @foreach ($data['rolesAndPermissions'] as $permissionRoles)
                            @if ($permissionRoles['role_id'] == $role->id && $permissionRoles['permis_id'] == $permission->id)
                                @php
                                    $checked = true;
                                @endphp
                            @endif
                        @endforeach

                        <td>
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" type="checkbox" 
                                        onclick="switchPermission(this)"
                                        id="role_permis_{{$role->id}}_{{$permission->id}}" 
                                        @if ($checked) checked @endif>
                                <label class="custom-control-label" for="role_permis_{{$role->id}}_{{$permission->id}}"></label>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
</div>

<script type="text/javascript">
    function switchPermission(elem){
        
        let idRole = elem.id.split("_")[2];
        let idPermission = elem.id.split("_")[3];
        let setStatus = Number(elem.checked);

        let params = "id_role="+idRole+"&id_permission="+idPermission;

        let action = "onPermissionRole";

        if (setStatus == 0) {
            action = "offPermissionRole";
        }

        fetch(action, {
		  method: 'POST',
		  headers: new Headers({
		     'Content-Type': 'application/x-www-form-urlencoded',
		     "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token').getAttribute('content')
		   }), 
		  body: params,
		})
		.then((data) => {
			console.log(data);
		});
    }
</script>
@endsection
