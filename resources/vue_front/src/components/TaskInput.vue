<template>
    <div class="input-group mb-3 bg-dark-theme" id="task-input">
        <input type="text" name="newTask" id="newTask" placeholder="Задача"
            size="100" class="form-control bg-dark-theme"
            v-bind:value="task" v-on:input="inputTask"> 
        <span class="input-group-append">
            <select class="form-select" name="priorityTask" id="priorityTask"
                v-bind:value="priority" v-on:change="selectPriority">
                <option value="0">Low</option>
                <option value="1">Middle</option>
                <option value="2">High</option>
            </select>
        </span>
        <span class="input-group-append">
            <button class="btn btn-secondary" id="add_task_btn" type="button" v-on:click="addTask()">
                <i class="fa fa-plus"></i>
            </button>
        </span>
    </div>
</template>

<script>
export default {
    name: 'TaskInput',
    data() {
        return {
            task: "",
            priority: 0,
            type: "",
            date: "",
            token: document.querySelector('meta[name=csrf-token').getAttribute('content')
        }
    },
    methods: {
        inputTask (event) {
            this.task = event.target.value;
        },
        selectPriority (event) {
            this.priority = event.target.value;
        },
        addTask () {
            this.date = this.getDateTime();
            this.type = window.location.href.split("/")[3];

            if (this.type == "demo") {
                this.saveTaskToLocalStorage();
            } else {
                let typeTask = 0;

                if (this.type == "bookmarks") {
                    typeTask = 3;
                }

                let params = "task=" + this.task
                    + "&date=" + this.date
                    + "&priority=" + this.priority
                    + "&type=" + typeTask;
                console.log(params);
                this.saveTaskOnServer(params);
            }
            
            this.cleanInput();
        },
        getDateTime () {
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); 
            let yyyy = today.getFullYear();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();

            return dd + '-' + mm + '-' + yyyy + " " + h + ":" + m + ":" + s;
        },
        saveTaskToLocalStorage () {
            let storage = localStorage.getItem('tasks');

            if (storage == null) {
                storage = [];
            } else {
                try {
                    storage = JSON.parse(storage);
                } catch (ex) {
                    storage = [];
                }
            }

            let newTask = {
                id: storage.length + 1 + Math.round(new Date().getTime()/1000.0),
                task: this.task,
                priority: this.priority,
                type: this.type,
                date: this.date
            }

            storage.push(newTask);

            this.$parent.tasks = storage;
            storage = JSON.stringify(storage);

            localStorage.setItem('tasks', storage);
        },
        saveTaskOnServer(params) {
            //var modal = new bootstrap.Modal(document.getElementById('modalWaitingServer'));
            //modal.show();

            try {
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
                    //modal.hide();

                    if (data?.errors != null) {
                        alert(data.errors?.task);
                        return false;
                    }
                    
                    if (data.id == null) {
                        alert("Количество задач в этом списке стало равным 50. Это количество нельзя превышать, займись делом.");
                    } else {
                        let taskData = {};
                        
                        taskData.id = data.id;
                        taskData.date = data.date;
                        taskData.task = this.b64DecodeUnicode(data.task);
                        taskData.priority = data.priorityTask;
                        taskData.type = data.type;

                        this.$parent.tasks.push(taskData);
                    }
                });
            } catch (ex) {
                //modal.hide();
            }
        },
        cleanInput () {
            this.task = "";
            this.priority = 0;
            this.date = "";
            this.type = "";
        },
        b64DecodeUnicode(str) {
            // Going backwards: from bytestream, to percent-encoding, to original string.
            return decodeURIComponent(atob(str).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
        }
    }
}
</script>

<style scoped>

</style>
