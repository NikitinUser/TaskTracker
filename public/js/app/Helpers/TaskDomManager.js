export default class TaskDomManager {

    static createDomTask(taskData){
        let li = document.getElementById("li-default").cloneNode(true);
        li.id = "";

        // дата
        li.querySelector(".li-date").textContent = taskData.date;

        // кнопка скрыть/показать
        li.querySelector(".li-btn-hid").id = 'show_' + taskData.id;

        // текст задачи
        let textTask = li.querySelector(".li-text-task");
        textTask.id = 'textid_' + taskData.id;
        textTask.textContent = taskData.task;

        let iPriority = document.createElement('i');
        let priorirtyId = li.querySelector(".li-priority-id");
        priorirtyId.id = 'priorityid_' + taskData.id;
        priorirtyId.value = 0;
        
        if (taskData.priority == 1) {
            iPriority.className = "fa fa-exclamation-circle text-warning";
            priorirtyId.value = 1;
        } else if (taskData.priority == 2) {
            iPriority.className = "fa fa-exclamation-circle text-danger";
            priorirtyId.value = 2;
        }

        textTask.append(iPriority);

        // кнопки
        let mainAction = li.querySelector(".li-main-action");
        mainAction.id = 'itembtnBookmarks_' + taskData.id;

        if (taskData.type == 0 || taskData.type == 2) {
            mainAction.className = "pull-right btn btn-outline-success w-100";
            mainAction.setAttribute('onclick', 'taskSwapType(this, 1)');
        } else {
            mainAction.className = "pull-right btn btn-outline-danger w-100";
            mainAction.setAttribute('onclick', 'deleteTask(this)');

            li.querySelector(".li-i-main-action").className = "fa fa-trash";
        }

        li.querySelector(".li-move-tasks").id = 'itembtnBookmarks_' + taskData.id;

        li.querySelector(".li-move-bookmarks").id = 'itembtnBookmarks_' + taskData.id;

        li.querySelector(".li-move-archive").id = 'itembtnBookmarks_' + taskData.id;

        li.querySelector(".li-edit-action").id = 'itembtnBookmarks_' + taskData.id;
      
        return li;
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