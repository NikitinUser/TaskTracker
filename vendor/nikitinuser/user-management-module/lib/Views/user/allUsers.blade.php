@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <table class="table table-striped">
                    <thead>
                        <th>id</th>
                        <th>Логин</th>
                        <th>Заблокирован</th>
                        <th>Дата начала роследней сессии</th>
                        <th>Дата регистрации</th>
                        <th>Удалить</th>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $value)
                            <tr>
                                <td>
                                    {{$value['id']}}
                                </td>

                                <td>
                                    {{$value['login']}}
                                </td>

                                <td>
                                    @if ($value['block'] == 1)
                                        Да
                                    @else
                                        Нет
                                    @endif
                                </td>

                                <td>
                                    {{$value['last_session']}}
                                </td>

                                <td>
                                    {{$value['created_at']}}
                                </td>

                                <td>
                                    <input type="button" id="user_{{$value['id']}}" class="btn btn-outline-danger btn-sm"
                                        onclick="deleteUser(this)" value="X">
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deleteUser(elem){
        let idUser = elem.id.split("_")[1];

        let params = "id_user="+idUser;

        fetch("removeUser", {
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
			window.location.reload();
		});
    }
</script>
@endsection