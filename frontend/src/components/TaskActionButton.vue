<template>
    <div class="me-2">
        <button v-bind:class="buttonClass" v-bind:id="idTask" v-on:click="taskBtnAction">
            <i v-bind:class="buttonIcon"></i>
        </button>
    </div>
</template>

<script>
import dateTimeMixin from './../mixins/dateTimeMixin';
import localStorageMixin from './../mixins/localStorageMixin';

export default {
    name: 'TaskActionButton',
    props: ['buttonClass', 'buttonIcon', 'action', 'idTask', 'changedTask', 'type'],
    mixins: [dateTimeMixin, localStorageMixin],
    data() {
        return {
            token: document.querySelector('meta[name=csrf-token').getAttribute('content')
        }
    },
    methods: {
        taskBtnAction () {
            if (this.action == "removeTaskFromLocal") {
                this.removeTaskFromLocal();
            } else if (this.action == "deleteTask") {
                this.deleteTask();
            } else if (this.action == "swapTaskToTasks") {
                this.taskSwapType(0);
            } else if (this.action == "swapTaskToDone") {
                this.taskSwapType(1);
            } else if (this.action == "swapTaskToArchive") {
                this.taskSwapType(2);
            } else if (this.action == "swapTaskToBookmarks") {
                this.taskSwapType(3);
            }
        },
        removeTaskFromLocal () {
            let storage = this.getTasksFromLocalStorage();

            let newStorage = [];
            for (let i = 0; i < storage.length; i++) {
                if (storage[i].id != this.idTask) {
                    newStorage.push(storage[i]);
                }
            }
            storage = JSON.stringify(newStorage);
            localStorage.setItem('tasks', storage);

            this.$emit("callRemoveTaskElement");
        },
        taskSwapType (type) {
            let nThis = this;
            this.callShowLoadingSpinner(true);

            let dateTime = this.getDateTime();
            let data = {
                id: this.idTask,
                task: this.changedTask,
                date: dateTime,
                type: type
            };

            try {
                fetch('tasks', {
                    method: 'PUT',
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

                    nThis.$emit("callRemoveTaskElement");
                });	
            } catch (ex) {
                console.log(ex);
                nThis.callShowLoadingSpinner(false);
            }
        },
        deleteTask () {
            let nThis = this;
            this.callShowLoadingSpinner(true);

            let data = {id: this.idTask};
            try {
                fetch('/tasks', {
                    method: 'DELETE',
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

                    nThis.$emit("callRemoveTaskElement");
                });	
            } catch (ex) {
                console.log(ex);
                nThis.callShowLoadingSpinner(false);
            }
        },
        callShowLoadingSpinner(show) {
            this.$emit("callShowLoadingSpinner", show);
        }
    }
}
</script>
