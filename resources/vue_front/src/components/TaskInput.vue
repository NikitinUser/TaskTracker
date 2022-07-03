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
            date: ""
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

            this.saveTaskToLocalStorage();
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
        cleanInput () {
            this.task = "";
            this.priority = 0;
            this.date = "";
            this.type = "";
        }
    }
}
</script>

<style scoped>

</style>
