@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-5 card p-3 ms-5 me-5">
        <form id="addRole" method="POST" class="row">
            @csrf
            
            <div class="mb-3">
                <lable>Название роли: </lable>
                <input type="text" name="role_name" class="form-control">
            </div>

            <div class="mb-3">
                <input type="button" value="Добавить" class="btn btn-primary" onclick="addRole()">
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function addRole() {
        form = document.getElementById("addRole");
        data = new FormData(form);

        token = document.querySelector('meta[name=csrf-token').getAttribute('content');

        fetch("addRole", {
            method: 'post',
            body: data,
            headers: new Headers({
                "X-CSRF-TOKEN": token
            }),
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log(data);
            window.location.replace("/getPageAllRolesAndPermissions")
        });
    }
</script>
@endsection