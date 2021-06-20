window.onload = function () {
	detectRoute();
}

function detectRoute() {
	var currentURL = window.location.href;

	var arrURL = currentURL.split("/");
	var route = arrURL[3];

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
	//console.log(route);
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

	var currentURL = window.location.href;
	var arrURL = currentURL.split("/");
	var route = arrURL[3];
	var typeTask = 0;

	if (route == "bookmarks") {
		typeTask = 3;
	}

	var params = "task=" + task + "&date=" + dateTime + "&priorityTask=" + priorityTask + "&type=" + typeTask;

	console.log(params);

	if (Number(task) !== 0 && task.lenght != 0){
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

function getDateTime(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); 
	var yyyy = today.getFullYear();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();

	return dd + '-' + mm + '-' + yyyy + " " + h + ":" + m + ":" + s;
}

function toDone(elem){
	var id = elem.getAttribute('id');
	id = id.split("_")[1];

	var dateTime = getDateTime();
	var params = "id=" + id + "&date=" + dateTime+ "&type=" + 1;

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

	startWaitingModal();

	fetch('toDone', {
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

function show_hidTask(elem){
	var id = elem.getAttribute('id');
	id = Number(id.split("_")[1]) ;
	var task = document.querySelector("#textid_" + id); 
	task.hidden = !task.hidden;
	if(task.hidden == true){
		elem.textContent = "Показать";
	}else{
		elem.textContent = "Скрыть";
	}
}

function hideAll(elem){
	var tasks = document.querySelectorAll(".taskText");
	let arrBtns = new Array();

	for(var i=0; i < tasks.length; i++){
		var id_task = tasks[i].getAttribute("id");
		var id = Number(id_task.split("_")[1]) ;
		arrBtns.push(document.querySelector("#show_"+id));
		tasks[i].hidden = !tasks[i].hidden;
	}
	
	if(tasks[0].hidden){
		elem.textContent = "Показать все";
		for(var i=0; i < arrBtns.length; i++){
			arrBtns[i].textContent = "Показать";
		}
	}else{
		elem.textContent = "Скрыть все";
		for(var i=0; i < arrBtns.length; i++){
			arrBtns[i].textContent = "Скрыть";
		}
	}
}


function toBookmarks(elem) {
	var id = elem.parentNode.getAttribute('id');
	id = id.split("_")[1];

	var dateTime = getDateTime();
	var params = "id=" + id + "&date=" + dateTime+ "&type=" + 3;

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

	startWaitingModal();

	fetch('toBookmark', {
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

function toArchive(elem) {
	var id = elem.parentNode.getAttribute('id');
	id = id.split("_")[1];

	var dateTime = getDateTime();
	var params = "id=" + id + "&date=" + dateTime+ "&type=" + 2;

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

	startWaitingModal();

	fetch('toArchive', {
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

function toTasks(elem) {
	var id = elem.parentNode.getAttribute('id');
	id = id.split("_")[1];

	var dateTime = getDateTime();
	var params = "id=" + id + "&date=" + dateTime+ "&type=0";

	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');

	startWaitingModal();

	fetch('toActive', {
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

function hideWaitingModal() {
	$("#modalWaitingServer").removeClass("in");
	$(".modal-backdrop").remove();
	document.querySelector("#modalWaitingServer").className = "modal fade";
	document.querySelector("#modalWaitingServer").style.display = "none";
	$("#modalWaitingServer").modal('hide');
	$('body').removeClass('modal-open');
}

function startWaitingModal() {
	document.querySelector("#modalWaitingServer").className = "modal fade show";
	document.querySelector("#modalWaitingServer").style.display = "block";
	$('#modalWaitingServer').modal('show');
}