class Task {

 	constructor(id, date, task, type, priority = 0) {
    	this.id = id;
    	this.date = date;
    	this.task = task;
    	this.type = type;
    	this.priority = priority;
 	}
	getNewTaskLi() {
	  	let liNew = document.createElement('li');
		liNew.className = "list-group-item";

		let divRowNew = document.createElement('div');
		divRowNew.className = "row";

		let divDateNew = document.createElement('div');
		divDateNew.className = "col-md-2 col-sm-2";

		let divTextNew = document.createElement('div');
		divTextNew.className = "col-md-9 col-sm-9 text-center";

		let divDoneNew = document.createElement('div');
		divDoneNew.className = "col-md-1 col-sm-1";

		let labelDate = document.createElement('label');
		let emDate = document.createElement('em');
		emDate.setAttribute('style', "font-size: small");
		emDate.append(this.date);
		labelDate.append(emDate);

		let spanNewText = document.createElement('span');
		spanNewText.className = "taskText";
		spanNewText.setAttribute('id', 'textid_' + this.id);

		let inputPriority = document.createElement('input');
		inputPriority.setAttribute('id', 'priorityid_' + this.id);
		inputPriority.setAttribute('type', 'hidden');
		inputPriority.value = 0;

		let iPriority = document.createElement('i');
		
		if (this.priority == 1) {
			iPriority.className = "fa fa-exclamation-circle text-warning";
			inputPriority.value = 1;
		} else if (this.priority == 2) {
			iPriority.className = "fa fa-exclamation-circle text-danger";
			inputPriority.value = 2;
		}

		let btnNewHide = document.createElement('button');
		btnNewHide.className = "btn btn-outline-secondary ntn-sm";
		btnNewHide.setAttribute('id', 'show_' + this.id);
		btnNewHide.setAttribute('style', 'font-size: x-small');
		btnNewHide.setAttribute('onclick', 'show_hidTask(this)');

		let btnNewDone = document.createElement('button');

		let iNewDone = document.createElement('i');

		if (this.type == 0 || this.type == 2) {
			
			btnNewDone.className = "pull-right btn btn-outline-success btn-sm";
			btnNewDone.setAttribute('id', 'idtask_' + this.id);
			btnNewDone.setAttribute('onclick', 'taskSwapType(this, 1)');

			
			iNewDone.className = "fa fa-check-square";
		} else {

			btnNewDone.className = "pull-right btn btn-outline-danger btn-sm";
			btnNewDone.setAttribute('id', 'idtask_' + this.id);
			btnNewDone.setAttribute('onclick', 'deleteTask(this)');

			iNewDone.className = "fa fa-trash";
		}

		let btnMoreActions = document.createElement('button');
		btnMoreActions.innerHTML = '<i class="fa fa-ellipsis-h" aria-hidden="true"></i>';
		btnMoreActions.className = "pull-right btn btn-outline-secondary btn-sm";
		btnMoreActions.setAttribute('id', 'idtaskMore_' + this.id);
		btnMoreActions.setAttribute('data-toggle', 'dropdown');

		let divDropMenu = document.createElement('div');
		divDropMenu.className = "dropdown-menu";
		divDropMenu.setAttribute('id', 'divDropMenu_' + this.id);
		divDropMenu.setAttribute('aria-labelledby', 'idtaskMore_' + this.id);
		divDropMenu.innerHTML = '<button class="dropdown-item" id="itembtnBookmarks_'+this.id+'" onclick="taskSwapType(this, 3)">В закладки</button>'+
								'<button class="dropdown-item" id="itembtnBookmarks_'+this.id+'" onclick="taskSwapType(this, 2)">В архив</button>'+
								'<button class="dropdown-item" id="itembtnBookmarks_'+this.id+'" onclick="taskSwapType(this, 0)">В задачи</button>'+
								'<button class="dropdown-item" id="itembtnBookmarks_'+this.id+'" onclick="modalChangeTask(this)">Изменить</button>';

		//btnMoreActions.setAttribute('onclick', 'deleteTask(this)');
		
		btnNewDone.append(iNewDone);
		btnNewHide.append('Скрыть');
		spanNewText.append(this.task);
		spanNewText.append(iPriority);
		spanNewText.append(inputPriority);

		divDateNew.append(labelDate);
		divDateNew.append(btnNewHide);
		divTextNew.append(spanNewText);
		if (btnNewDone.id != "")
			divDoneNew.append(btnNewDone);
		divDoneNew.append(btnMoreActions);
		divDoneNew.append(divDropMenu);
		
		divRowNew.append(divDateNew);
		divRowNew.append(divTextNew);
		divRowNew.append(divDoneNew);

		liNew.append(divRowNew);
		this.liNew = liNew;

	    return liNew;
	}
}