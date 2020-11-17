@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-body">
            	<div class="input-group mb-3">
            		<input type="text" name="newTask" id="newTask" placeholder="Задача" size="100" class="form-control"> 
            		<span class="input-group-append">
            			<button class="btn btn-primary" type="button" onclick="addTask()">
            				<i class="fa fa-plus"></i>
            			</button>
            		</span>
            	</div> 
            	<ul class="list-group list-group-flush" id="list_tasks">
            		@if (!empty($tasks))
            			@foreach ($tasks as $task)
            				<li class="list-group-item">
		            			<div class="row">
		            				<div class=" col-md-1 col-sm-1">
		            					<input type="checkbox" class="pull-left">
		            					<label><em style="font-size: x-small">{{ $task['dt_send'] }}</em></label>
		            				</div> 
		            				<div class="col-md-10 col-sm-10 text-center">
				                        {{ $task['task'] }}
				                    </div> 
				                    <div class="col-md-1 col-sm-1">
				                    	<button class="pull-right btn btn-outline-danger btn-sm " id="idtask_{{$task['id']}}" onclick="toTrash(this)">
				                    		<i class="fa fa-trash"></i>
				                    	</button>
				                    </div>
				                </div>
				            </li>
            			@endforeach
            		@endif
            		
		        </ul>

            </div>
        </div>
        
    </div>
</div>

        

@endsection