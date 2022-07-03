<template>
    <div v-bind:id="id" style="min-height: 200px;">
        <div>
            <div class="d-flex flex-row" style="min-height: 150px;">
                <div class="text-white d-flex flex-column" style="max-width: 20%">
                    <div class="mb-3">
                        <label class="task-theme" v-bind:id="id"></label>
                    </div>

                    <div class="mb-3 d-flex flex-column">
                        <em class="li-date" style="font-size: small"></em>
                        <em class="li-date-time" style="font-size: small"></em>
                    </div>

                    <div>
                        <button type="button" class="btn btn-outline-light btn-sm li-btn-hid"
                            v-on:click="visibleTask=!visibleTask">
                            {{visibleTask?'Скрыть':'Показать'}}
                        </button>
                    </div>
                </div>

                <div class="text-white flex-fill ms-3 me-1">
                    <span v-bind:id="id" class="li-text-task" v-show="visibleTask">
                        {{ task }}
                        <i class="li-i-priority ms-1"></i>
                    </span>
                    <input v-bind:id="id" type="hidden" class="li-priority-id" v-bind:value="priority">
                </div>
            </div>

            <div class="text-white d-flex flex-row pull-right"
                v-if="currentRoute == 'demo'">
                <TaskActionButton
                    buttonIcon = "fa fa-check-square li-i-main-action"
                    buttonClass = "pull-right btn btn-outline-success w-100 li-main-action"
                    action = "removeTaskFromLocal"
                    :idTask="id"
                ></TaskActionButton>
            </div>
            <div class="text-white d-flex flex-row pull-right"
                v-else>
                <TaskActionButton 
                    v-if="currentRoute != 'done'"
                    buttonIcon = "fa fa-check-square li-i-main-action"
                    buttonClass = "pull-right btn btn-outline-success w-100 li-main-action"
                    action = "swapTaskToDone"
                    :idTask="id"
                ></TaskActionButton>

                <TaskActionButton
                    v-else
                    buttonIcon = "fa fa-trash"
                    buttonClass = "pull-right btn btn-outline-danger w-100 li-main-action"
                    action = "deleteTask"
                    :idTask="id"
                ></TaskActionButton>

                <TaskActionButton
                    buttonIcon = "fa fa-location-arrow"
                    buttonClass = "pull-right btn btn-outline-success w-100 li-move-tasks"
                    action = "swapTaskToTasks"
                    :idTask="id"
                ></TaskActionButton>

                <TaskActionButton
                    buttonIcon = "fa fa-bookmark"
                    buttonClass = "pull-right btn btn-outline-primary w-100 li-move-bookmarks"
                    action = "swapTaskToBookmarks"
                    :idTask="id"
                ></TaskActionButton>

                <TaskActionButton
                    buttonIcon = "fa fa-archive"
                    buttonClass = "pull-right btn btn-outline-info w-100 li-move-archive"
                    action = "swapTaskToArchive"
                    :idTask="id"
                ></TaskActionButton>

                <TaskActionButton
                    buttonIcon = "fa fa-pencil-square"
                    buttonClass = "pull-right btn btn-outline-warning w-100 li-edit-action"
                    action = "editTask"
                    :idTask="id"
                ></TaskActionButton>
            </div>
        </div>

        <div id="recoveryTask" class="justify-content-center pt-5"
            style="display: none">
            <button class="btn btn-outline-primary" type="button"
                v-on:click="recoverTask">
                Восстановить
            </button>
        </div>

        <TaskEditModal
            v-show="visibleModalChange"
            :id="id"
            :priority="priority"
            :task="task"
        ></TaskEditModal>
    </div>
</template>

<script>
import TaskActionButton from './TaskActionButton.vue'
import TaskEditModal from './TaskEditModal.vue'

export default {
    name: 'TaskItem',
    components: {
        TaskActionButton,
        TaskEditModal
    },
    props: ['task', 'priority', 'type', 'date', 'id'],
    data() {
        return {
            visibleTask: true,
            visibleModalChange: false,
            currentRoute: window.location.href.split("/")[3],
            token: document.querySelector('meta[name=csrf-token').getAttribute('content')
        }
    },
    methods: {
        recoverTask () {
            //var modal = new bootstrap.Modal(document.getElementById('modalWaitingServer'));
            //modal.show();
            let params = "id=" + this.id;
            try {
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
                    //modal.hide();

                    if (data?.errors != null) {
                        alert(data.errors?.task);
                        return false;
                    }

                    if(data.length != 0 && data != false && data != null){
                        location.reload();
                    } else {
                        alert("Эту запись нельзя восстановить");
                        location.reload();
                    }
                });	
            } catch (ex) {
                //modal.hide();
            }
        },
    }
}
</script>

<style scoped>

</style>
