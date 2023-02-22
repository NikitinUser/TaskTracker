@extends('layouts.app')

@section('content')
<div class="row me-5 ms-5">
    <div class="card col-md-12 p-3 justify-content-center">
        <table class="table table-striped">
            <th style="width: 150px; !important">Пользователи\Роли</th>
            @foreach ($data['roles'] as $key => $role)
                <th style="width: 100px; !important"> 
                    <a href="getPageEditRole?role_id={{ $role?->id}}">{{ $role?->role_name}}</a>
                </th>
            @endforeach

            @foreach ($data['users'] as $key => $user)
                <tr>
                    <td>
                        {{ $user->login}}
                    </td>

                    @foreach ($data['roles'] as $key => $role)
                        @php
                            $checked = false;
                        @endphp

                        @foreach ($data['roles_for_user'] as $rolesForUser)
                            @if ($rolesForUser['id_role'] == $role->id && $rolesForUser['id_user'] == $user->id)
                                @php
                                    $checked = true;
                                @endphp
                            @endif
                        @endforeach

                        <td>
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" type="checkbox" 
                                        onclick="switchRole(this)"
                                        id="user_role_{{$user->id}}_{{$role->id}}" 
                                        @if ($checked) checked @endif>
                                <label class="custom-control-label" for="user_role_{{$user->id}}_{{$role->id}}"></label>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
</div>

<script type="text/javascript">
    function switchRole(elem){
        
        let idUser = elem.id.split("_")[2];
        let idRole = elem.id.split("_")[3];
        let setStatus = Number(elem.checked);

        let params = "id_user="+idUser+"&id_role="+idRole;

        let action = "onUserRole";

        if (setStatus == 0) {
            action = "offUserRole";
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
