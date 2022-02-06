@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-center">
                <div class="card">
                    <form action="editPermission" method="POST" class="row">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <lable>Название права: </lable>
                            <input type="text" name="permission_name" id="permission_name" class="form-control" value="{{$data[0]['permission_name']}}">
                            <input type="hidden" id="permission_id" name="permission_id" value="{{$data[0]['id']}}">
                        </div>

                        <div class="col-md-12 d-flex">
                            <div class="mb-3 mr-3">
                                <input type="submit" value="Изменить" class="btn btn-primary">
                            </div>
                            <div class="mb-3">
                                <input type="button" id="permission_{{$data[0]['id']}}" class="btn btn-outline-danger"
                                    onclick="deletePermission(this)" value="Удалить">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deletePermission(elem){
        let idPermission = elem.id.split("_")[1];

        let params = "id_permission="+idPermission;

        fetch("deletePermission", {
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