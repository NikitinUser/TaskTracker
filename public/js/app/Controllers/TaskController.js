import TaskModel from "./../Models/TaskModel.js";
import {getDateTime} from "./../functions/dateFunctions.js";

export default class TaskController{
    taskModel;

    constructor() {
        this.taskModel = new TaskModel();
    }

    getDoneTasks () {
        document.querySelector("#div-done-tasks").hidden = false;
		document.querySelector("#div-add-task").hidden = true;
		this.taskModel.loadTasks(1);
    }

    getArchiveTasks () {
        document.querySelector("#div-done-tasks").hidden = true;
		document.querySelector("#div-add-task").hidden = true;
		this.taskModel.loadTasks(2);
    }

    getBookmarksTasks () {
        document.querySelector("#div-add-task").hidden = false;
		this.taskModel.loadTasks(3);
    }

    getActiveTasks () {
        document.querySelector("#div-add-task").hidden = false;
		this.taskModel.loadTasks(0);
    }

    addTask (route) {
        let task = document.querySelector('#newTask').value;
        task = task.replace(/&/g, "%26");
        let dateTime = getDateTime();
        let priorityTask = document.querySelector('#priorityTask').value;

        let typeTask = 0;

        if (route == "bookmarks") {
            typeTask = 3;
        }

        let params = "task=" + task + "&date=" + dateTime + "&priorityTask=" + priorityTask + "&type=" + typeTask;

        console.log(params);

        if (Number(task) !== 0 && task.length > 3)
            this.taskModel.addTask(params);
    }

    taskSwapType (elem, type) {
        let id = elem.getAttribute('id');
        id = id.split("_")[1];

        let dateTime = getDateTime();
        let params = "id=" + id + "&date=" + dateTime+ "&type=" + type;

        this.taskModel.currentDomElement = elem;
        this.taskModel.taskSwapType(params);
    }

    deleteTask(elem){
        var id = elem.getAttribute('id');
        id = id.split("_")[1];

        var params = "id=" + id;

        this.taskModel.currentDomElement = elem;
        this.taskModel.deleteTask(params);
    }

    recoverTask(elem){
        var id = elem.getAttribute('id');
        id = id.split("_")[1];

        var params = "id=" + id;

        this.taskModel.currentDomElement = elem;
        this.taskModel.recoverTask(params);
    }

    changeTask(){
        var id = document.querySelector("#idChangeTaskModal").value;

        var task = document.querySelector('#contentChangeTaskModal').value;
        task = task.replace(/&/g, "%26");

        var priorityTask = document.querySelector('#priorityChangeTaskModal').value;

        var params = "task=" + task + "&priorityTask=" + priorityTask + "&id=" + id;

        if (Number(task) !== 0 && task.length != 0)
            this.taskModel.changeTask(params);
    }
}