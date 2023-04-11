<template>
    <div class="p-2 bg-dark-theme" id="task-input">
        <span id="count_new_task" class="text-white" style="font-size: small">0/2100</span>
        <textarea type="text" name="newTask" id="newTask" placeholder="Задача"
            size="100" maxlength="2100" class="form-control bg-dark-theme"
            v-bind:value="task" v-on:input="inputTask($event); autoHeight($event)"
            v-on:blur="autoHeight" v-on:focus="autoHeight"
        ></textarea>

        <div class="d-flex justify-content-center mt-1">
            <button class="btn btn-secondary btn-lg rounded-circle" id="add_task_btn" type="button"
                v-on:click="addTask()">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
</template>

<script>
import dateTimeMixin from './../mixins/dateTimeMixin';
import localStorageMixin from './../mixins/localStorageMixin';

export default {
    name: 'TaskInput',
    mixins: [dateTimeMixin, localStorageMixin],
    props: ['currentRoute'],
    data() {
        return {
            task: "",
            date: "",
            token: document.querySelector('meta[name=csrf-token').getAttribute('content')
        }
    },
    methods: {
        inputTask (event) {
            this.task = event.target.value;
            document.getElementById("count_new_task").textContent = event.target.value.length + "/2100";
        },
        addTask() {
            this.date = this.getDateTime();

            if (this.currentRoute == "/demo") {
                this.saveTaskToLocalStorage();
            } else {
                let typeTask = 0;

                if (this.currentRoute == "/bookmarks") {
                    typeTask = 3;
                }
                
                let data = {
                    task: this.task,
                    date: this.date,
                    type: typeTask
                };
                this.saveTaskOnServer(data);
            }
            
            this.cleanInput();
        },
        saveTaskToLocalStorage() {
            let storage = this.getTasksFromLocalStorage();

            let newTask = {
                id: storage.length + 1 + this.date,
                task: this.task,
                date: this.date
            };

            storage.push(newTask);
            storage = JSON.stringify(storage);
            localStorage.setItem('tasks', storage);

            this.callPushTask(newTask);
        },
        saveTaskOnServer(data) {
            this.callShowLoadingSpinner(true);

            let nThis = this;

            try {
                fetch('/tasks', {
                    method: 'POST',
                    headers: new Headers({
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.token
                    }), 
                    body: JSON.stringify(data)
                })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    nThis.callShowLoadingSpinner(false);

                    if (data?.errors != null) {
                        alert(data.errors?.task);
                        return false;
                    }
                    
                    if (data.id == null) {
                        alert("Количество задач в этом списке стало равным 50. Это количество нельзя превышать, займись делом.");
                    } else {
                        nThis.callPushTask(data);
                    }
                });
            } catch (ex) {
                console.log(ex);
                nThis.callShowLoadingSpinner(false);
            }
        },
        cleanInput () {
            this.task = "";
            this.date = "";

            document.getElementById("newTask").style.height = "60px";
            document.getElementById("count_new_task").textContent = "0/2100"
        },
        autoHeight(event) {
            event.target.style.height = "60px";
            event.target.style.height = (event.target.scrollHeight)+"px";
        },
        callShowLoadingSpinner(show) {
            this.$emit("callShowLoadingSpinner", show);
        },
        callPushTask(task) {
            this.$emit("callPushTask", task);
        }
    }
}
</script>
