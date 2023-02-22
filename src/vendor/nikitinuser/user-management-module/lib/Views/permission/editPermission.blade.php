@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-5 card p-3 ms-5 me-5">
        <form id="editPermission" method="POST" class="row">
            @csrf
            <div class="col-md-12 mb-3">
                <lable>Название права: </lable>
                <input type="text" name="permission_name" id="permission_name" class="form-control" value="{{$permission?->permission_name}}">
                <input type="hidden" id="permission_id" name="permission_id" value="{{$permission?->id}}">
            </div>

            <div class="col-md-12 d-flex">
                <div class="mb-3 me-3">
                    <input type="button" value="Изменить" class="btn btn-primary" onclick="editPermission()">
                </div>
                <div class="mb-3">
                    <input type="button" id="permission_{{$permission?->id}}" class="btn btn-outline-danger"
                        onclick="deletePermission(this)" value="Удалить">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function editPermission() {
        form = document.getElementById("editPermission");
        data = new FormData(form);

        token = document.querySelector('meta[name=csrf-token').getAttribute('content');

        fetch("editPermission", {
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

    function deletePermission(elem) {
        form = document.getElementById("editPermission");
        data = new FormData(form);

        fetch("deletePermission", {
		  method: 'POST',
		  headers: new Headers({
		     "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token').getAttribute('content')
		   }), 
		  body: data,
		})
		.then((data) => {
			window.location.replace("/getPageAllRolesAndPermissions");
		});
    }
</script>

@endsection