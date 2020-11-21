@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-body">
            	<form method="POST" action="settings/send">
            		@csrf
	            	<div class="form-group">
	            		<label for="chat_id">id telegram-аккаунта (для отправки уведомлений):</label>
	            		<input type="text" id="chat_id" name="chat_id" class="form-control">
	            		<input type="submit" value="Сохранить" class="form-control btn btn-outline-secondary">
	            	</div>
            	</form>

            </div>
        </div>
        
    </div>
</div>

        

@endsection