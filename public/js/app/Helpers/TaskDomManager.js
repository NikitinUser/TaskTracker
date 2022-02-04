export default class TaskDomManager {

    static createDomTask(taskData){
        let liNew = document.createElement('li');
        liNew.className = "list-group-item list-group-item-purple border border-dark";

        let divRowNew = document.createElement('div');
        divRowNew.className = "row";

        let divDateNew = document.createElement('div');
        divDateNew.className = "col-md-2 col-sm-2 text-white";

        let divTextNew = document.createElement('div');
        divTextNew.className = "col-md-9 col-sm-9 text-center text-white";

        let divDoneNew = document.createElement('div');
        divDoneNew.className = "col-md-1 col-sm-1 col-1 dropdown";

        let labelDate = document.createElement('label');
        let emDate = document.createElement('em');
        emDate.setAttribute('style', "font-size: small");
        emDate.append(taskData.date);
        labelDate.append(emDate);

        let spanNewText = document.createElement('span');
        spanNewText.className = "taskText";
        spanNewText.setAttribute('id', 'textid_' + taskData.id);

        let inputPriority = document.createElement('input');
        inputPriority.setAttribute('id', 'priorityid_' + taskData.id);
        inputPriority.setAttribute('type', 'hidden');
        inputPriority.value = 0;

        let iPriority = document.createElement('i');
        
        if (taskData.priority == 1) {
            iPriority.className = "fa fa-exclamation-circle text-warning";
            inputPriority.value = 1;
        } else if (taskData.priority == 2) {
            iPriority.className = "fa fa-exclamation-circle text-danger";
            inputPriority.value = 2;
        }

        let btnNewHide = document.createElement('button');
        btnNewHide.className = "btn btn-outline-light ntn-sm";
        btnNewHide.setAttribute('id', 'show_' + taskData.id);
        btnNewHide.setAttribute('style', 'font-size: x-small');
        btnNewHide.setAttribute('onclick', 'show_hidTask(this)');

        let btnNewDone = document.createElement('button');

        let iNewDone = document.createElement('i');

        if (taskData.type == 0 || taskData.type == 2) {
            
            btnNewDone.className = "pull-right btn btn-outline-success btn-sm";
            btnNewDone.setAttribute('id', 'idtask_' + taskData.id);
            btnNewDone.setAttribute('onclick', 'taskSwapType(this, 1)');

            
            iNewDone.className = "fa fa-check-square";
        } else {

            btnNewDone.className = "pull-right btn btn-outline-danger btn-sm";
            btnNewDone.setAttribute('id', 'idtask_' + taskData.id);
            btnNewDone.setAttribute('onclick', 'deleteTask(this)');

            iNewDone.className = "fa fa-trash";
        }

        let btnMoreActions = document.createElement('button');
        btnMoreActions.innerHTML = '<i class="fa fa-ellipsis-h" aria-hidden="true"></i>';
        btnMoreActions.className = "pull-right btn btn-outline-light btn-sm";
        btnMoreActions.setAttribute('id', 'idtaskMore_' + taskData.id);
        btnMoreActions.setAttribute('data-bs-toggle', 'dropdown');
        btnMoreActions.setAttribute('aria-haspopup', false);
        btnMoreActions.setAttribute('type', 'button');

        let divDropMenu = document.createElement('div');
        divDropMenu.className = "dropdown-menu";
        divDropMenu.setAttribute('id', 'divDropMenu_' + taskData.id);
        divDropMenu.setAttribute('aria-labelledby', 'idtaskMore_' + taskData.id);
        divDropMenu.innerHTML = '<button class="dropdown-item" id="itembtnBookmarks_'+taskData.id+'" onclick="taskSwapType(this, 0)">В задачи</button>'
                                +'<button class="dropdown-item" id="itembtnBookmarks_'+taskData.id+'" onclick="taskSwapType(this, 2)">В архив</button>'
                                +'<button class="dropdown-item" id="itembtnBookmarks_'+taskData.id+'" onclick="taskSwapType(this, 3)">В закладки</button>'
                                +'<button class="dropdown-item" id="itembtnBookmarks_'+taskData.id+'" onclick="modalChangeTask(this)">Изменить</button>';
        
        btnNewDone.append(iNewDone);
        btnNewHide.append('Скрыть');
        spanNewText.append(taskData.task);
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
        taskData.liNew = liNew;

        return liNew;
    }

    static deleteDomTask(elem){
        let id = elem.id.split("_")[1];

        let parentDiv = elem.parentNode.parentNode.parentNode;
        parentDiv.removeChild(elem.parentNode.parentNode);

        let divRecover = document.createElement("div");
        divRecover.className = "row justify-content-center";

        let btnRecover = document.createElement("button");
        btnRecover.className = "btn btn-outline-primary btn-sm";
        btnRecover.type = "button";
        btnRecover.textContent = "Восстановить";
        btnRecover.setAttribute('id', 'btnRecover_' + id);
        btnRecover.setAttribute('onclick', 'recoverTask(this)');

        divRecover.append(btnRecover);

        parentDiv.append(divRecover);
    }
}