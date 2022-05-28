export default class TaskDomManager {

    static createDomTask(taskData){
        let li = document.getElementById("li-default").cloneNode(true);
        li.id = "";
        li.removeAttribute('hidden');
        li.children[0].id = "li-div_" + taskData.id;

        if (taskData.date != undefined && taskData.date != null) {
            li.querySelector(".li-date").textContent = taskData.date.split(" ")[0];
            li.querySelector(".li-date-time").textContent = taskData.date.split(" ")[1];
        }

        li.querySelector(".li-btn-hid").id = 'show_' + taskData.id;

        let textTask = li.querySelector(".li-text-task");
        textTask.id = 'textid_' + taskData.id;
        textTask.className += " taskText";
        textTask.prepend(taskData.task);

        let priorirtyId = li.querySelector(".li-priority-id");
        priorirtyId.id = 'priorityid_' + taskData.id;
        priorirtyId.value = taskData.priority;
        
        if (taskData.priority == 1) {
            li.querySelector(".li-i-priority").className += " fa fa-exclamation-circle text-warning";
        } else if (taskData.priority == 2) {
            li.querySelector(".li-i-priority").className += " fa fa-exclamation-circle text-danger";
        }

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

        let parentDiv = document.getElementById("li-div_"+id).parentNode;
        parentDiv.removeChild(document.getElementById("li-div_"+id));

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
