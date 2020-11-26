function addTask(){
	var task = document.querySelector('#newTask').value;
	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');
	var params = "_token=" + token + "&task=" + task;
	if (Number(task) !== 0 && task.lenght != 0){
		ajaxPost('/home/addtask', params, function(data){
			if(data != ''){
				document.querySelector("#list_tasks").insertAdjacentHTML('beforeend', data);
				document.querySelector('#newTask').value = "";
			} 
		});
	}
}

function toTrash(elem){
	var id = elem.getAttribute('id');
	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');
	var params = "_token=" + token + "&id=" + id;
	
	ajaxPost('/home/totrash', params, function(data){
		if(data != ''){
			if(Number(data) == 1){
				elem.parentNode.parentNode.parentNode.parentNode.removeChild(elem.parentNode.parentNode.parentNode);
			}
		} 
	});
	
}

function deleteTask(elem){
	var id = elem.getAttribute('id');
	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');
	var params = "_token=" + token + "&id=" + id;
	
	ajaxPost('/trash/deleteTask', params, function(data){
		if(data != ''){
			if(Number(data) == 1){
				elem.parentNode.parentNode.parentNode.parentNode.removeChild(elem.parentNode.parentNode.parentNode);
			}
		} 
	});
	
}

function ConfirmSendTelegramTask(elem){
	var id = elem.getAttribute('id');
	var new_btn = document.querySelector(".send");
	new_btn.setAttribute('id', 'n'+id);
	$('#sendConfirmModal').modal("show");
}

function sendTelegramTask(elem){
	var minuts = 0;
	if(typeof document.querySelector("#minuts") !== 'undefined' && document.querySelector("#minuts") !== null){
		minuts = document.querySelector("#minuts");
		minuts = Number(minuts.value);
	}
	if(isNaN(minuts)){
		minuts = 0;
	}
	var id = elem.getAttribute('id');
	var token = document.querySelector('meta[name=csrf-token').getAttribute('content');
	var params = "_token=" + token + "&id=" + id + "&minuts=" + minuts;

	ajaxPost('/settings/send', params, function(data){
		if(data != ''){
			if(Number(data) == 1){
				console.log("sent");
				//elem.parentNode.parentNode.parentNode.parentNode.removeChild(elem.parentNode.parentNode.parentNode);
			}
		} 
	});
}

function ajaxPost(url, params, callback){
	var f = callback || function(data){};
	var request = new XMLHttpRequest();
	
	request.onreadystatechange = function(){
		if (request.readyState==4 && request.response != ''){
			var myObj = request.response;
			f(myObj);
		}
	}
	
	request.open('POST', url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}