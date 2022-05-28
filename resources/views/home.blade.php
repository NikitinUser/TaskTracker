@extends('layouts.app')
@section('content')

<div class="container bg-dark-theme">
    <div class="row justify-content-center bg-dark-theme">
        <div class="col-md-9 bg-dark-theme">
            <div class="card-body bg-dark-theme">
            	<div class="input-group mb-3 bg-dark-theme" id="div-add-task" hidden="true">
            		<input type="text" name="newTask" id="newTask" placeholder="Задача" size="100" class="form-control bg-dark-theme"> 
            		<span class="input-group-append">
            			<select class="form-select" name="priorityTask" id="priorityTask">
            				<option value="0"> Low </option>
            				<option value="1"> Middle</option>
            				<option value="2"> High</option>
            			</select>
            		</span>
            		<span class="input-group-append">
            			<button class="btn btn-secondary" id="add_task_btn" type="button" onclick="addTask()">
            				<i class="fa fa-plus"></i>
            			</button>
            		</span>
            	</div> 

            	<div class="mb-3 border border-success border-left-0 border-right-0 border-top-0 text-white" id="div-done-tasks" hidden="true">
            		<center>Выполненные задачи</center>
            	</div>

            	<div class="mb-3">
            		<center>
            			<button class="btn btn-outline-light btn-sm" type="button" onclick="hideAll(this)">Скрыть все</button>
            		</center>
            	</div>
            	<ul class="list-group list-group-flush bg-dark-tasks-theme" id="list_tasks"></ul>
              
              <div class="mt-3">
                @auth
                    <center>
                        <a href="#top" class="btn btn-outline-light btn-sm">Наверх</a>
                    </center>
                @endauth
              </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content text-white">
              <div class="modal-header bg-dark-theme">
                <h5 class="modal-title" id="exampleModalLabel">Редактирование</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body bg-dark-theme">
                <input type="hidden" id="idChangeTaskModal" value="">

                <div>
                    <label>Текст:</label>
                    <textarea class="form-control" id="contentChangeTaskModal" rows="3"></textarea>
                </div>
                
                <div>
                    <label>Приоритетность:</label>
                    <select class="form-select" id="priorityChangeTaskModal">
                        <option value="0"> Low </option>
                        <option value="1"> Middle</option>
                        <option value="2"> High</option>
                    </select>
                </div>
                
              </div>
              <div class="modal-footer bg-dark-theme">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" onclick="changeTask()">Сохранить</button>
              </div>
            </div>
          </div>
        </div>        

        <li class="list-group-item list-group-item-darktheme border border-dark" id="li-default">
          <div class="d-flex flex-row" style="min-height: 150px;">
            <div class="text-white d-flex flex-column">
              <div class="mb-3">
                <em class="li-date" style="font-size: small"></em>
              </div>

              <div>
                <input type="button" class="btn btn-outline-light btn-sm li-btn-hid" onclick='show_hidTask(this)' value="Скрыть">
              </div>
            </div>

            <div class="text-white flex-fill ms-5 me-3">
              <span class="li-text-task taskText"></span>
              <i class="li-i-priority"></i>
              <input type="hidden" class="li-priority-id">
            </div>

            <div class="text-white d-flex flex-column">
              <div class="mb-2">
                <button class="pull-right btn btn-outline-success w-100 li-main-action"><i class="fa fa-check-square li-i-main-action"></i></button>
              </div>

              <div class="mb-2">
                <button class="pull-right btn btn-outline-success w-100 li-move-tasks" onclick="taskSwapType(this, 0)"><i class="fa fa-location-arrow"></i></button>
              </div>

              <div class="mb-2">
                <button class="pull-right btn btn-outline-primary w-100 li-move-bookmarks" onclick="taskSwapType(this, 3)"><i class="fa fa-bookmark"></i></button>
              </div>

              <div class="mb-2">
                <button class="pull-right btn btn-outline-info w-100 li-move-archive" onclick="taskSwapType(this, 2)"><i class="fa fa-archive"></i></button>
              </div>

              <div class="mb-2">
                <button class="pull-right btn btn-outline-warning w-100 li-edit-action" onclick="modalChangeTask(this)"><i class="fa fa-pencil-square"></i></button>
              </div>
            </div>
          </div>
        </li>
    </div>
</div>

<footer class="page-footer mt-2 mb-3">

</footer>

<script type="module" src="{{ asset('js/main.js') }}" ></script>

<script type="text/javascript">
	document.addEventListener('keydown', function(event) {
	  if (event.keyCode === 13) {
	   	addTask();
	  }
	});

</script>	

@endsection
