@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-10">
            <div class="card-body">
            	<div class="input-group mb-3" id="div-add-task" hidden="true">
            		<input type="text" name="newTask" id="newTask" placeholder="Задача" size="100" class="form-control"> 
            		<span class="input-group-append">
            			<select class="custom-select" name="priorityTask" id="priorityTask">
            				<option value="0"> Low </option>
            				<option value="1"> Middle</option>
            				<option value="2"> High</option>
            			</select>
            		</span>
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
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактирование</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" id="idChangeTaskModal" value="">

                <div>
                    <label>Текст:</label>
                    <textarea class="form-control" id="contentChangeTaskModal" rows="3"></textarea>
                </div>
                
                <div>
                    <label>Приоритетность:</label>
                    <select class="custom-select" id="priorityChangeTaskModal">
                        <option value="0"> Low </option>
                        <option value="1"> Middle</option>
                        <option value="2"> High</option>
                    </select>
                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" onclick="changeTask()">Сохранить</button>
              </div>
            </div>
          </div>
        </div>        
    </div>
</div>

<footer class="page-footer mt-2 mb-3">
@auth
    <center>
        <a href="#top" class="btn btn-outline-secondary btn-sm ">Наверх</a>
    </center>
@endauth
</footer>

<script src="{{ asset('js/Task.js') }}" ></script>
<script src="{{ asset('js/dateTime.js') }}" ></script>
<script src="{{ asset('js/hiddingElements.js') }}" ></script>
<script src="{{ asset('js/modalWaiting.js') }}" ></script>
<script src="{{ asset('js/main.js') }}" ></script>

<script type="text/javascript">
	document.addEventListener('keydown', function(event) {
	  if (event.keyCode === 13) {
	   	addTask();
	  }
	});

</script>	

@endsection
