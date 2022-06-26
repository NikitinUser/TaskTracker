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

window.filtreByTheme = filtreByTheme;
window.dropThemeFiltre = dropThemeFiltre;
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

    getTasksThemes();
}

function getTasksThemes() {
    fetch('get_tasks_themes', {
        method: 'GET'
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log(data);
            for (let i = 0; i < data.length; i++) {
                let option = document.createElement('option');
                option.value = data[i]?.theme ?? "Без темы";
                document.getElementById("suggestions-themes").append(option);
                option.textContent = data[i]?.theme ?? "Без темы";
                document.getElementById("theme-filtre").append(option);
            }
        });
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

    document.querySelector('#themeChangeTaskModal').value = document.querySelector('#theme_'+id).textContent;

    var modalChangeTask = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalChangeTask.show();
}

function changeTask(){
    taskController.changeTask()
}


function filtreByTheme(){
    let theme = document.getElementById("theme-filtre").value;

    let data = document.querySelectorAll(".task-theme");

    for (let i = 0; i < data.length; i++) {
        if (data[i].textContent != theme && data[i]?.id != null) {
            changeHiddenElemForThemes(data[i].id, true);
        } else if (data[i].textContent == theme && data[i]?.id != null) {
            changeHiddenElemForThemes(data[i].id, false);
        }

        if (theme.length == 0 && data[i]?.id != null) {
            changeHiddenElemForThemes(data[i].id, false);
        }
         
    }
}

function changeHiddenElemForThemes(idElem, hidden){
    let id = idElem.split("_")[1];
    if (id != undefined) {
        id = "li-task_" + id;
        document.getElementById(id).hidden = hidden;
    }
}

function dropThemeFiltre(){
    let data = document.querySelectorAll(".li_task_elem");

    for (let i = 0; i < data.length; i++) {
        data[i].hidden = false;
    }

    document.getElementById("theme-filtre").value = "";
}
