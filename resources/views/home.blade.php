@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-body">
            	<div class="input-group mb-3" id="div-add-task" hidden="true">
            		<input type="text" name="newTask" id="newTask" placeholder="Задача" size="100" class="form-control"> 
            		<span class="input-group-append">
            			<button class="btn btn-secondary" type="button" onclick="addTask()">
            				<i class="fa fa-plus"></i>
            			</button>
            		</span>
            	</div> 

            	<div class="mb-3 border border-success border-left-0 border-right-0 border-top-0" id="div-done-tasks" hidden="true">
            		<center>Выполненные задачи</center>
            	</div>

            	<div class="mb-3 ">
            		<center>
            			<button class="btn btn-outline-secondary btn-sm" type="button" onclick="hideAll(this)">Скрыть все</button>
            		</center>
            	</div>
            	<ul class="list-group list-group-flush" id="list_tasks">
            		
		        </ul>

            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
	document.addEventListener('keydown', function(event) {
	  if (event.keyCode === 13) {
	   	addTask();
	  }
	});

</script>	

@endsection
