@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <table class="table table-striped">
                    <th style="width: 150px; !important">Пользователи\Роли</th>

                    @foreach ($data['roles'] as $key => $value)
                        <th style="width: 100px; !important"> 
                            <a href="getPageEditRole?role_id={{ $value['id'] ?? '0' }}">{{ $value['role_name'] ?? "-" }}</a>
                        </th>
                    @endforeach
                    
                    @foreach ($data['users'] as $key => $value)

                        <tr>

                            <td>
                                {{ $value['login'] ?? "-" }}
                            </td>

                            @foreach ($value['status'] as $key => $val)
                                <td>
                                    @if ($val == 1)
                                    <form>
                                        <div class="custom-control custom-switch">
                                            <input class="custom-control-input" type="checkbox" 
                                                    onclick="switchRole(this)"
                                                    id="user_role_{{$value['id']}}_{{$key}}" 
                                                    checked>
                                            <label class="custom-control-label" for="user_role_{{$value['id']}}_{{$key}}"></label>
                                        </div>
                                    </form>
                                    @else
                                    <form>
                                        <div class="custom-control custom-switch">
                                            <input class="custom-control-input" type="checkbox" 
                                                    onclick="switchRole(this)"
                                                    id="user_role_{{$value['id']}}_{{$key}}">
                                            <label class="custom-control-label" for="user_role_{{$value['id']}}_{{$key}}"></label>
                                        </div>
                                    </form>    
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        
                    @endforeach
                </table>
            </div>
        </div>
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
		.then((response) => {
		    return response.json();
		})
		.then((data) => {
			console.log(data);
		});
    }
</script>

@endsection
