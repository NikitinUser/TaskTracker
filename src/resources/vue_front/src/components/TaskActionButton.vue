<template>
    <div class="me-2">
        <button v-bind:class="buttonClass" v-bind:id="idTask" v-on:click="taskBtnAction">
            <i v-bind:class="buttonIcon"></i>
        </button>
    </div>
</template>

<script>
import dateTimeMixin from './../mixins/dateTimeMixin';

export default {
    name: 'TaskActionButton',
    props: ['buttonClass', 'buttonIcon', 'action', 'idTask', 'changedTask', 'type'],
    mixins: [dateTimeMixin],
    data() {
        return {
            token: document.querySelector('meta[name=csrf-token').getAttribute('content')
        }
    },
    methods: {
        taskBtnAction () {
            if (this.action == "removeTaskFromLocal") {
                this.removeTaskFromLocal();
            } else if (this.action == "swapTaskToDone") {
                this.taskSwapType(1);
            } else if (this.action == "deleteTask") {
                this.deleteTask();
            } else if (this.action == "swapTaskToTasks") {
                this.taskSwapType(0);
            } else if (this.action == "swapTaskToBookmarks") {
                this.taskSwapType(3);
            } else if (this.action == "swapTaskToArchive") {
                this.taskSwapType(2);
            } else if (this.action == "editTask") {
                this.$parent.visibleModalChange = true;
            }
        },
        removeTaskFromLocal () {
            let storage = this.$parent.$parent.getTasksFromLocalStorage();

            let newStorage = [];
            for (let i=0; i < storage.length; i++) {
                if (storage[i].id != this.idTask) {
                    newStorage.push(storage[i]);
                }
            }

            this.$parent.$parent.tasks = newStorage;
            storage = JSON.stringify(newStorage);

            localStorage.setItem('tasks', storage);
        },
        taskSwapType (type) {
            var parentEl = this.$parent.$parent;
            parentEl.showLoadingSpinner = true;

            let dateTime = this.getDateTime();
            let params = "task=" + this.changedTask + "&id=" + this.idTask + "&date=" + dateTime+ "&type=" + type;

            try {
                fetch('tasks', {
                method: 'PUT',
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

                    this.$parent.$el.parentNode.removeChild(this.$parent.$el);
                });	
            } catch (ex) {
                console.log(ex);
                parentEl.showLoadingSpinner = false;
            }
        },
        deleteTask () {
            var parentEl = this.$parent.$parent;
            parentEl.showLoadingSpinner = true;

            var params = "id=" + this.idTask;
            try {
                fetch('/tasks', {
                method: 'DELETE',
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

                    this.$parent.$el.removeChild(this.$parent.$el.children[0]);
                });	
            } catch (ex) {
                console.log(ex);
                parentEl.showLoadingSpinner = false;
            }
        }
    }
}
</script>
