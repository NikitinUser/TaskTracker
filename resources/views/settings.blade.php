@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <label class="card-header">Как пользоваться уведомлениями в телеграмм</label>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Дать команду start боту @TTSendBot (он будет отправлять задачи)</li>
                    <li class="list-group-item">Получить свой id у бота @ShowJsonBot (ориентироваться на строку "chat": { )</li>
                    <li class="list-group-item">Полученный id ввести на этой странице ниже и нажать кнопку "сохранить"</li>
                    <li class="list-group-item">
                        На странице задач появится кнопка <i class="fa fa-telegram" aria-hidden="true"></i>
                        При нажатии на кнопку откроется окно, в котором будет предложено ввести количество минут через которое должно прийти сообщение о задаче. (Максимум 600 минут)
                    </li>
                </ul>
            </div>
        </div>
        <div class="card col-md-8 mt-3">
            <div class="card-body">
            	<form method="POST" action="settings/send">
            		@csrf
	            	<div class="form-group">
                        <label for="chat_id">id telegram-аккаунта (для отправки уведомлений):</label>
                        <div class="col-md-6">                            
                            <input type="text" id="chat_id" name="chat_id" class="form-control">
                        </div>
	            		<div class="col-md-6 mt-2">  
                            <input type="submit" value="Сохранить" class="form-control btn btn-outline-secondary">
                        </div>
	            		
	            	</div>
            	</form>
            </div>
        </div>
        <div class="card col-md-8 mt-3">
            <div class="card-body">
                <div class="col-md-6 mt-2">  
                    <input type="submit" value="Удалить аккаунт" class="form-control btn btn-outline-danger">
                </div>
            </div>
        </div>
    </div>
</div>

        

@endsection