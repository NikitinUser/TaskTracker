export function show_hidTask(elem){
	var id = elem.getAttribute('id');
	id = Number(id.split("_")[1]) ;
	var task = document.querySelector("#textid_" + id); 
	task.hidden = !task.hidden;
	if(task.hidden == true){
		elem.value = "Показать";
	}else{
		elem.value = "Скрыть";
	}
}

export function hideAll(elem){
	var tasks = document.querySelectorAll(".taskText");
	let arrBtns = new Array();

	let hiddenAll = true;

	if (elem.textContent == "Показать все") {
		elem.textContent = "Скрыть все";
		hiddenAll = false;
	} else {
		elem.textContent = "Показать все";
	}

	for(var i=0; i < tasks.length; i++){
		var id_task = tasks[i].getAttribute("id");
		var id = Number(id_task.split("_")[1]);
		tasks[i].hidden = hiddenAll;

		if (hiddenAll) {
			document.querySelector("#show_"+id).value = "Показать";
		} else {
			document.querySelector("#show_"+id).value = "Скрыть";
		}
	}
}
