import TaskDomManager from "./../Helpers/TaskDomManager.js";

export default class Task{
    token;
    currentDomElement;

    constructor () {
        this.token = document.querySelector('meta[name=csrf-token').getAttribute('content');
    }

    loadTasks (typeRequest) {
        let route = '/get_tasks';
        route += "?type=" + typeRequest;
        this.type = typeRequest;

        startWaitingModal();

        fetch(route)
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            hideWaitingModal();
            for (let i = 0; i < data.length; i++) {
                let taskData = {};
                taskData.id = data[i].id;
                taskData.date = data[i].dt_task;
                taskData.task = data[i].task;
                taskData.priority = data[i].priority;
                taskData.type = this.type;
                    
                let liNew = TaskDomManager.createDomTask(taskData);

                document.querySelector("#list_tasks").append(liNew);
                document.querySelector('#newTask').value = "";
            }
        });
    }

    addTask(params) {
		startWaitingModal();

		fetch('addTask', {
		  method: 'POST',
		  headers: new Headers({
		     'Content-Type': 'application/x-www-form-urlencoded',
		     "X-CSRF-TOKEN": this.token
		   }), 
		  body: params,
		})
		.then((response) => {
		    return response.json();
		})
		.then((data) => {
			hideWaitingModal();

		    if (data.id == null) {
				alert("Количество задач в этом списке стало равным 50. Это количество нельзя превышать, займись делом.");
			} else {
                let taskData = {};
                
                taskData.id = data.id;
                taskData.date = data.date;
                taskData.task = this.b64DecodeUnicode(data.task);
                taskData.priority = data.priorityTask;
                taskData.type = data.type;

                let liNew = TaskDomManager.createDomTask(taskData);

				document.querySelector("#list_tasks").append(liNew);
				document.querySelector('#newTask').value = "";
			}
		});
    }

    b64DecodeUnicode(str) {
        // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    }
    
    taskSwapType (params) {
        startWaitingModal();

        fetch('taskSwapType', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded',
            "X-CSRF-TOKEN": this.token
        }), 
        body: params,
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            hideWaitingModal();

            if(Number(data) == 1){
                this.currentDomElement.parentNode.parentNode.parentNode.parentNode.removeChild(this.currentDomElement.parentNode.parentNode.parentNode);
            } else {
                alert("Ошибка");
            }
        });	
    }

    deleteTask(params){
        startWaitingModal();

        fetch('deleteTask', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded',
            "X-CSRF-TOKEN": this.token
        }), 
        body: params,
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            hideWaitingModal();

            if(Number(data) == 1){
                TaskDomManager.deleteDomTask(this.currentDomElement);
            }
        });	
    }

    recoverTask(params){
        startWaitingModal();

        fetch('recoverTask', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded',
            "X-CSRF-TOKEN": this.token
        }), 
        body: params,
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            hideWaitingModal();

            if(data.length != 0 && data != false && data != null){
                let parentDiv = this.currentDomElement.parentNode.parentNode.parentNode;
                parentDiv.removeChild(this.currentDomElement.parentNode.parentNode);

                let taskData = {};
                taskData.id = data[i].id;
                taskData.date = data[i].date;
                taskData.task = data[i].task;
                taskData.priority = data[i].priorityTask;
                taskData.type = this.type;

                let liNew = TaskDomManager.createDomTask(taskData);

                parentDiv.append(liNew);

            } else {
                alert("Эту запись нельзя восстановить");
                location.reload();
            }
        });	
    }

    changeTask(params){
        startWaitingModal();

		fetch('changeTask', {
		  method: 'POST',
		  headers: new Headers({
		     'Content-Type': 'application/x-www-form-urlencoded',
		     "X-CSRF-TOKEN": this.token
		   }), 
		  body: params,
		})
		.then((response) => {
		    return response.json();
		})
		.then((data) => {
			hideWaitingModal();
		    location.reload();
		});
    }
}