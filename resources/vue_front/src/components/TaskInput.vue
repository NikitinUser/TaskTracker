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
            <button class="btn btn-secondary" id="add_task_btn" type="button"
                v-on:click="addTask()">
                <i class="fa fa-plus"></i>
            </button>
        </span>
    </div>
</template>

<script>
import dateTimeMixin from './../mixins/dateTimeMixin';

export default {
    name: 'TaskInput',
    mixins: [dateTimeMixin],
    data() {
        return {
            task: "",
            priority: 0,
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

            if (this.$parent.currentRoute == "/demo") {
                this.saveTaskToLocalStorage();
            } else {
                let typeTask = 0;

                if (this.$parent.currentRoute == "/bookmarks") {
                    typeTask = 3;
                }

                let params = "task=" + this.task
                    + "&date=" + this.date
                    + "&priority=" + this.priority
                    + "&type=" + typeTask;
                this.saveTaskOnServer(params);
            }
            
            this.cleanInput();
        },
        saveTaskToLocalStorage () {
            let storage = this.$parent.getTasksFromLocalStorage();

            let newTask = {
                id: storage.length + 1 + this.date,
                task: this.task,
                priority: this.priority,
                date: this.date
            };

            storage.push(newTask);

            this.$parent.tasks = storage;
            storage = JSON.stringify(storage);

            localStorage.setItem('tasks', storage);
        },
        saveTaskOnServer(params) {
            var parentEl = this.$parent;
            parentEl.showLoadingSpinner = true;

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
                    parentEl.showLoadingSpinner = false;

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
                        taskData.task = data.task;
                        taskData.priority = data.priorityTask;
                        taskData.type = data.type;

                        this.$parent.tasks.push(taskData);
                    }
                });
            } catch (ex) {
                console.log(ex);
                parentEl.showLoadingSpinner = false;
            }
        },
        cleanInput () {
            this.task = "";
            this.priority = 0;
            this.date = "";
        }
    }
}
</script>
