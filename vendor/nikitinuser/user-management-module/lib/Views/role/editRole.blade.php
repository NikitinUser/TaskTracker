@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-center">
                <div class="card">
                    <form action="editRole" method="POST" class="row">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <lable>Название роли: </lable>
                            <input type="text" name="role_name" id="role_name" class="form-control" value="{{$data[0]['role_name']}}">
                            <input type="hidden" id="role_id" name="role_id" value="{{$data[0]['id']}}">
                        </div>

                        <div class="col-md-12 d-flex">
                            <div class="mb-3 mr-3">
                                <input type="submit" value="Изменить" class="btn btn-primary">
                            </div>
                            <div class="mb-3">
                                <input type="button" id="role_{{$data[0]['id']}}" class="btn btn-outline-danger"
                                    onclick="deleteRole(this)" value="Удалить">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deleteRole(elem){
        let idRole = elem.id.split("_")[1];

        let params = "id_role="+idRole;

        fetch("deleteRole", {
		  method: 'POST',
		  headers: new Headers({
		     'Content-Type': 'application/x-www-form-urlencoded',
		     "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token').getAttribute('content')
		   }), 
		  body: params,
		})
		.then((response) => {
		    return response.json();
		})
		.then((data) => {
			window.location.replace("getPageAllRoles");
		});
    }
</script>

@endsection