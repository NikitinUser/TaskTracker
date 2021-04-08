class Task {

 	constructor(id, date, task, type) {
    	this.id = id;
    	this.date = date;
    	this.task = task;
    	this.type = type;
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

		let btnNewHide = document.createElement('button');
		btnNewHide.className = "btn btn-outline-secondary ntn-sm";
		btnNewHide.setAttribute('id', 'show_' + this.id);
		btnNewHide.setAttribute('style', 'font-size: x-small');
		btnNewHide.setAttribute('onclick', 'show_hidTask(this)');

		let btnNewDone = document.createElement('button');

		let iNewDone = document.createElement('i');

		if (this.type == 0) {
			
			btnNewDone.className = "pull-right btn btn-outline-success btn-sm";
			btnNewDone.setAttribute('id', 'idtask_' + this.id);
			btnNewDone.setAttribute('onclick', 'toDone(this)');

			
			iNewDone.className = "fa fa-check-square";
		} else {	//if (this.type = 1)

			btnNewDone.className = "pull-right btn btn-outline-danger btn-sm";
			btnNewDone.setAttribute('id', 'idtask_' + this.id);
			btnNewDone.setAttribute('onclick', 'deleteTask(this)');

			iNewDone.className = "fa fa-trash";
		}
		
		btnNewDone.append(iNewDone);
		btnNewHide.append('Скрыть');
		spanNewText.append(this.task);

		divDateNew.append(labelDate);
		divDateNew.append(btnNewHide);
		divTextNew.append(spanNewText);
		divDoneNew.append(btnNewDone);

		divRowNew.append(divDateNew);
		divRowNew.append(divTextNew);
		divRowNew.append(divDoneNew);

		liNew.append(divRowNew);
		this.liNew = liNew;

	    return liNew;
	}
}