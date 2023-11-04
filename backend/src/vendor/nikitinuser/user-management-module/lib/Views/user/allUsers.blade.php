@extends('layouts.app')

@section('content')
<div class="row me-5 ms-5">
    <div class="card col-md-12 p-3 justify-content-center">
        <table class="table table-striped">
            <thead>
                <th>id</th>
                <th>Логин</th>
                <th>Заблокирован</th>
                <th>Дата начала последней сессии</th>
                <th>Дата регистрации</th>
                <th>Удалить</th>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                    <tr>
                        <td>
                            {{$user?->id}}
                        </td>

                        <td>
                            {{$user?->login}}
                        </td>

                        <td>
                            @if ($user?->block == 1)
                                Да
                            @else
                                Нет
                            @endif
                        </td>

                        <td>
                            {{$user?->last_session}}
                        </td>

                        <td>
                            {{$user?->created_at}}
                        </td>

                        <td>
                            <input type="button" id="user_{{$user?->id}}" class="btn btn-outline-danger btn-sm"
                                onclick="deleteUser(this)" value="X">
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
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
		.then((data) => {
			window.location.reload();
		});
    }
</script>
@endsection