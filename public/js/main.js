import TaskController from "./app/Controllers/TaskController.js";
import {show_hidTask, hideAll} from "./app/functions/hiddingElements.js";

/* Для видимости функций за пределами модуля */
window.addTask = addTask;

window.taskSwapType = taskSwapType;
window.deleteTask = deleteTask;
window.recoverTask = recoverTask;
window.modalChangeTask = modalChangeTask;
window.changeTask = changeTask;

window.show_hidTask = show_hidTask;
window.hideAll = hideAll;
/* --- */


var route = detectRoute();

var taskController = new TaskController();

window.onload = function () {
    switch(route) {
        case 'done': 
            taskController.getDoneTasks();
            break;
      
        case 'archive':  
            taskController.getArchiveTasks();
            break;

        case 'bookmarks':  
            taskController.getBookmarksTasks();
            break;
      
        default:
            taskController.getActiveTasks();
            break;
    }
}

function hideAdminSideBar() {
    let detect = new MobileDetect(window.navigator.userAgent)
    if (detect.mobile() != null)
        if (document.querySelector("#AdminSideBar") != null) 
            document.querySelector("#AdminSideBar").style.display = "none";
}


function detectRoute() {
	let arrURL = window.location.href.split("/");

	return arrURL[3];
}

function addTask(){
    taskController.addTask(route);
}

function taskSwapType(elem, num){
    taskController.taskSwapType(elem, num)
}

function deleteTask(elem){
    taskController.deleteTask(elem)
}

function recoverTask(elem){
    taskController.recoverTask(elem)
}

function modalChangeTask(elem) {
	var id = elem.id;
	id = id.split("_")[1];

	document.querySelector("#idChangeTaskModal").value = id;

	document.querySelector('#contentChangeTaskModal').value = document.querySelector('#textid_'+id).textContent;
	document.querySelector('#priorityChangeTaskModal').value = document.querySelector('#priorityid_'+id).value;

    var modalChangeTask = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalChangeTask.show();
}

function changeTask(){
    taskController.changeTask()
}
