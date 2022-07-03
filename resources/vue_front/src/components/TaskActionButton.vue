<template>
    <div class="me-2">
        <button v-bind:class="buttonClass"
            v-bind:id="idTask" v-on:click="taskBtnAction">
            <i v-bind:class="buttonIcon"></i>
        </button>
    </div>
</template>

<script>
export default {
    name: 'TaskActionButton',
    props: ['buttonClass', 'buttonIcon', 'action', 'idTask'],
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
            //var modal = new bootstrap.Modal(document.getElementById('modalWaitingServer'));
            //modal.show();
            console.log(this.idTask);
            let dateTime = this.getDateTime();
            let params = "id=" + this.idTask + "&date=" + dateTime+ "&type=" + type;

            try {
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
                    //modal.hide();
                    if (data?.errors != null) {
                        alert(data.errors?.task);
                        return false;
                    }

                    if(Number(data) == 1){
                        this.$parent
                            .$el
                            .parentNode
                            .removeChild(this.$parent.$el);
                    } else {
                        alert("Ошибка");
                    }
                });	
            } catch (ex) {
                //modal.hide();
            }
        },
        deleteTask () {
            //var modal = new bootstrap.Modal(document.getElementById('modalWaitingServer'));
            //modal.show();
            var params = "id=" + this.idTask;
            try {
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
                    //modal.hide();

                    if (data?.errors != null) {
                        alert(data.errors?.task);
                        return false;
                    }

                    if(Number(data) == 1){
                        this.$parent
                            .$el
                            .removeChild(this.$parent.$el.children[0]);

                        this.$parent.$el.children[0].style.display = "flex";
                    }
                });	
            } catch (ex) {
                //modal.hide();
            }
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
        }
    }
}
</script>
