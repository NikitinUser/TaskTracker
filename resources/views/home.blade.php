@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-body">
            	@if (url()->current() == "http://t-tasktracker.ru/home" || url()->current() == "http://t-tasktracker.ru")
	            	<div class="input-group mb-3">
	            		<input type="text" name="newTask" id="newTask" placeholder="Задача" size="100" class="form-control"> 
	            		<span class="input-group-append">
	            			<button class="btn btn-secondary" type="button" onclick="addTask()">
	            				<i class="fa fa-plus"></i>
	            			</button>
	            		</span>
	            	</div> 
	            @elseif (url()->current() == "http://t-tasktracker.ru/trash")
	            	<div class="mb-3">
	            		<center>Удаленные задачи</center>
	            	</div>
            	@endif
            	<ul class="list-group list-group-flush" id="list_tasks">
            		@if (!empty($tasks))
            			@foreach ($tasks as $task)
            				<li class="list-group-item">
		            			<div class="row">
		            				<div class=" col-md-1 col-sm-1">
		            					<label><em style="font-size: x-small">{{ $task['dt_send'] . "(мск)" }}</em></label>
		            					<button class="btn btn-outline-secondary ntn-sm" style="font-size: x-small" id="show_{{$task['id']}}" onclick="show_hidTask(this)">Скрыть</button>
		            				</div> 
		            				<div class="col-md-10 col-sm-10 text-center">
		            					<span id="textid_{{ $task['id'] }}">
		            						{{ $task['task'] }}
		            					</span>
				                        
				                    </div> 
				                    <div class="col-md-1 col-sm-1">
				                    	@if (url()->current() == "http://t-tasktracker.ru/home" || url()->current() == "http://t-tasktracker.ru")
				                    		<button class="pull-right btn btn-outline-danger btn-sm " id="idtask_{{$task['id']}}" onclick="toTrash(this)">
					                    		<i class="fa fa-trash"></i>
					                    	</button>
					                    	@if (!empty($chat_id))
					                    		<button class="pull-right btn btn-outline-secondary btn-sm " id="sendidtask_{{$task['id']}}" onclick="ConfirmSendTelegramTask(this)">
						                    		<i class="fa fa-telegram" aria-hidden="true"></i>
						                    	</button>
					                    	@endif
				                    	@elseif (url()->current() == "http://tasktracker.ru/trash")
				                    		<button class="pull-right btn btn-outline-danger btn-sm " id="idtask_{{$task['id']}}" onclick="deleteTask(this)">
					                    		<i class="fa fa-trash"></i>
					                    	</button>
				                    	@endif
				                    </div>
				                </div>
				            </li>
            			@endforeach
            		@endif
            		
		        </ul>

            </div>
            <div class="modal" id="sendConfirmModal" tabindex="-1">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title">Отправить через:</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <input type="text" name="minuts" id="minuts">
			        <label for="minuts">минут</label>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
			        <button type="button" class="btn btn-primary send" id="" onclick="sendTelegramTask(this)">Отправить</button>
			      </div>
			    </div>
			  </div>
			</div>
        </div>
        
    </div>
</div>

        

@endsection
