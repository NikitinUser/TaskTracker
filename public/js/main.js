window.onload = function () {
	var route = detectRoute();
	loadTasksForCurrent(route);
}

function detectRoute() {
	var arrURL = window.location.href.split("/");

	return arrURL[3];
}

function loadTasksForCurrent(route) {
	if (route == "done") {
		document.querySelector("#div-done-tasks").hidden = false;
		document.querySelector("#div-add-task").hidden = true;
		loadTasks('/get_tasks', 1);
	} else if (route == "archive") {
		document.querySelector("#div-done-tasks").hidden = true;
		document.querySelector("#div-add-task").hidden = true;
		loadTasks('/get_tasks', 2);
	} else if (route == "bookmarks") {
		document.querySelector("#div-add-task").hidden = false;
		 loadTasks('/get_tasks', 3);
	} else {
		 document.querySelector("#div-add-task").hidden = false;
		 loadTasks('/get_tasks', 0);
	}
}

function loadTasks(route, type) {
	route += "?type=" + type;

	startWaitingModal();

	fetch(route)
	  .then((response) => {
	    return response.json();
	  })
	  .then((data) => {
	  	hideWaitingModal();
	    for (var i = 0; i < data.length; i++) {
			var taskLi = new Task(data[i].id, data[i].dt_task, data[i].task, type, data[i].priority);
			var liNew = taskLi.getNewTaskLi();

			document.querySelector("#list_tasks").append(liNew);
			document.querySelector('#newTask').value = "";
		}
	});
}

function addTask(){
	var task = document.querySelector('#newTask').value;
	task = task.replace(/&/g, "%26");
	var dateTime = getDateTime();
	var priorityTask = document.querySelector('#priorityTask').value;

	var route = detectRoute();
	var typeTask = 0;

	if (route == "bookmarks") {
		typeTask = 3;
	}

	var params = "task=" + task + "&date=" + dateTime + "&priorityTask=" + priorityTask + "&type=" + typeTask;

	console.log(params);

	if (Number(task) !== 0 && task.lenght > 3){
		var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

		startWaitingModal();

		fetch('addTask', {
		  method: 'POST',
		  headers: new Headers({
		     'Content-Type': 'application/x-www-form-urlencoded',
		     "X-CSRF-TOKEN": token
		   }), 
		  body: params,
		})
		.then((response) => {
		    return response.json();
		})
		.then((data) => {
			hideWaitingModal();

		    if (data.id == null) {
				alert("Количество задач в этом списке стало равным 50. Это количество нельзя превышать, займись делом.");
			} else {
				var taskLi = new Task(data['id'], data['date'], task, typeTask, priorityTask);
				var liNew = taskLi.getNewTaskLi();

				document.querySelector("#list_tasks").append(liNew);
				document.querySelector('#newTask').value = "";
			}
		});
	}
}

function taskSwapType(elem, type){
	var id = elem.getAttribute('id');
	id = id.split("_")[1];

	var dateTime = getDateTime();
	var params = "id=" + id + "&date=" + dateTime+ "&type=" + type;

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

	startWaitingModal();

	fetch('taskSwapType', {
	  method: 'POST',
	  headers: new Headers({
	     'Content-Type': 'application/x-www-form-urlencoded',
	     "X-CSRF-TOKEN": token
	   }), 
	  body: params,
	})
	.then((response) => {
	    return response.json();
	})
	.then((data) => {
		hideWaitingModal();

	    if(Number(data) == 1){
			elem.parentNode.parentNode.parentNode.parentNode.removeChild(elem.parentNode.parentNode.parentNode);
		} else {
			alert("Ошибка");
		}
	});	
}

function deleteTask(elem){
	var id = elem.getAttribute('id');
	id = id.split("_")[1];

	var params = "id=" + id;

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

	startWaitingModal();

	fetch('deleteTask', {
	  method: 'POST',
	  headers: new Headers({
	     'Content-Type': 'application/x-www-form-urlencoded',
	     "X-CSRF-TOKEN": token
	   }), 
	  body: params,
	})
	.then((response) => {
	    return response.json();
	})
	.then((data) => {
		hideWaitingModal();

	    if(Number(data) == 1){
			var parentDiv = elem.parentNode.parentNode.parentNode;
			parentDiv.removeChild(elem.parentNode.parentNode);

			var divRecover = document.createElement("div");
			divRecover.className = "row justify-content-center";

			var btnRecover = document.createElement("button");
			btnRecover.className = "btn btn-outline-primary btn-sm";
			btnRecover.type = "button";
			btnRecover.textContent = "Восстановить";
			btnRecover.setAttribute('id', 'btnRecover_' + id);
			btnRecover.setAttribute('onclick', 'recoverTask(this)');

			divRecover.append(btnRecover);

			parentDiv.append(divRecover);
		}
	});	
}

function recoverTask(elem){
	var id = elem.getAttribute('id');
	id = id.split("_")[1];

	var params = "id=" + id;

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

	startWaitingModal();

	fetch('recoverTask', {
	  method: 'POST',
	  headers: new Headers({
	     'Content-Type': 'application/x-www-form-urlencoded',
	     "X-CSRF-TOKEN": token
	   }), 
	  body: params,
	})
	.then((response) => {
	    return response.json();
	})
	.then((data) => {
		hideWaitingModal();

	    if(data.length != 0 && data != false && data != null){
			var parentDiv = elem.parentNode.parentNode.parentNode;
			parentDiv.removeChild(elem.parentNode.parentNode);

			var taskLi = new Task(data.id, data.dt_task, data.task, data.typeTask, data.priorityTask);
			var liNew = taskLi.getNewTaskLi();

			parentDiv.append(liNew);

		} else {
			alert("Эту запись нельзя восстановить");
			location.reload();
		}
	});		
}

function modalChangeTask(elem) {
	var id = elem.parentNode.getAttribute('id');
	id = id.split("_")[1];

	document.querySelector("#idChangeTaskModal").value = id;

	document.querySelector('#contentChangeTaskModal').value = document.querySelector('#textid_'+id).textContent;
	document.querySelector('#priorityChangeTaskModal').value = document.querySelector('#priorityid_'+id).value;

	$('#exampleModal').modal('show');
}

function changeTask() {
	var id = document.querySelector("#idChangeTaskModal").value;

	var task = document.querySelector('#contentChangeTaskModal').value;
	task = task.replace(/&/g, "%26");

	var priorityTask = document.querySelector('#priorityChangeTaskModal').value;

	var params = "task=" + task + "&priorityTask=" + priorityTask + "&id=" + id;

	if (Number(task) !== 0 && task.lenght != 0){
		startWaitingModal();

		var token = document.querySelector('meta[name=csrf-token').getAttribute('content');
		fetch('changeTask', {
		  method: 'POST',
		  headers: new Headers({
		     'Content-Type': 'application/x-www-form-urlencoded',
		     "X-CSRF-TOKEN": token
		   }), 
		  body: params,
		})
		.then((response) => {
		    return response.json();
		})
		.then((data) => {
			hideWaitingModal();
		    location.reload();
		});
	}
}