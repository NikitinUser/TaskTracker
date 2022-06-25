@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-5 card p-3 ms-5 me-5">
        <form id="editRole" method="POST" class="row">
            @csrf
            <div class="col-md-12 mb-3">
                <lable>Название роли: </lable>
                <input type="text" name="role_name" id="role_name" class="form-control"
                    value="{{$role?->role_name}}">
                <input type="hidden" id="role_id" name="role_id" value="{{$role?->id}}">
            </div>

            <div class="col-md-12 d-flex">
                <div class="mb-3 me-3">
                    <input type="button" value="Изменить" class="btn btn-primary"
                        onclick="editRole(this)">
                </div>
                <div class="mb-3">
                    <input type="button" id="role_{{$role?->id}}" class="btn btn-outline-danger"
                        onclick="deleteRole(this)" value="Удалить">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function editRole() {
        form = document.getElementById("editRole");
        data = new FormData(form);

        token = document.querySelector('meta[name=csrf-token').getAttribute('content');

        fetch("editRole", {
            method: 'post',
            body: data,
            headers: new Headers({
                "X-CSRF-TOKEN": token
            }),
        })
        .then((data) => {
            window.location.replace("/getPageAllRolesAndPermissions")
        });
    }

    function deleteRole(elem){
        form = document.getElementById("editRole");
        data = new FormData(form);

        fetch("deleteRole", {
		  method: 'POST',
		  headers: new Headers({
		     "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token').getAttribute('content')
		   }), 
		  body: data,
		})
		.then((data) => {
			window.location.replace("getPageAllRolesAndPermissions");
		});
    }
</script>

@endsection