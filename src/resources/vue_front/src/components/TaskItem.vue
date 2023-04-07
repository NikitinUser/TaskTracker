<template>
    <div v-bind:id="id">
        <div>
            <div class="text-white mb-3 row">
                <div class="col-2"><em style="font-size: small">{{ date }}</em></div>

                <div class="col-10">
                    <div class="text-white d-flex flex-row pull-right"
                        v-if="currentRoute == '/demo'">
                        <TaskActionButton
                            buttonIcon = "fa fa-check-square"
                            buttonClass = "pull-right btn btn-outline-success btn-sm w-100"
                            action = "removeTaskFromLocal"
                            :idTask="id"
                            :changedTask="task"
                            :type="type"
                        ></TaskActionButton>
                    </div>
                    <div class="text-white d-flex flex-row pull-right"
                        v-else>
                        <TaskActionButton 
                            v-if="currentRoute != '/done'"
                            buttonIcon = "fa fa-check-square"
                            buttonClass = "pull-right btn btn-outline-success btn-sm w-100"
                            action = "swapTaskToDone"
                            :idTask="id"
                            :changedTask="task"
                            :type="type"
                        ></TaskActionButton>

                        <TaskActionButton
                            v-else
                            buttonIcon = "fa fa-trash"
                            buttonClass = "pull-right btn btn-outline-danger btn-sm w-100"
                            action = "deleteTask"
                            :idTask="id"
                            :changedTask="task"
                            :type="type"
                        ></TaskActionButton>

                        <TaskActionButton
                            buttonIcon = "fa fa-location-arrow"
                            buttonClass = "pull-right btn btn-outline-success btn-sm w-100"
                            action = "swapTaskToTasks"
                            :idTask="id"
                            :changedTask="task"
                            :type="type"
                        ></TaskActionButton>

                        <TaskActionButton
                            buttonIcon = "fa fa-bookmark"
                            buttonClass = "pull-right btn btn-outline-primary btn-sm w-100"
                            action = "swapTaskToBookmarks"
                            :idTask="id"
                            :changedTask="task"
                            :type="type"
                        ></TaskActionButton>

                        <TaskActionButton
                            buttonIcon = "fa fa-archive"
                            buttonClass = "pull-right btn btn-outline-info btn-sm w-100"
                            action = "swapTaskToArchive"
                            :idTask="id"
                            :changedTask="task"
                            :type="type"
                        ></TaskActionButton>

                        <TaskActionButton
                            buttonIcon = "fa fa-pencil-square"
                            buttonClass = "pull-right btn btn-outline-warning btn-sm w-100"
                            action = "editTask"
                            :idTask="id"
                        ></TaskActionButton>
                    </div>

                    <div class="text-white d-flex flex-row pull-right me-2">
                        <button type="button" class="btn btn-outline-light btn-sm"
                            v-on:click="visibleTask=!visibleTask">
                            <i v-if="visibleTask" class="fa fa-eye-slash" aria-hidden="true"></i>
                            <i v-else class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="text-white mb-2">
                <textarea v-bind:id="'task_' + id" v-show="visibleTask" class="form-control"
                    :value="task" maxlength="2100" readonly></textarea>
            </div>
        </div>

        <TaskEditModal
            v-show="visibleModalChange"
            :id="id"
            :task="task"
            :type="type"
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
    props: ['task', 'type', 'date', 'id'],
    data() {
        return {
            visibleTask: true,
            visibleModalChange: false,
            currentRoute: window.location.pathname,
            token: document.querySelector('meta[name=csrf-token').getAttribute('content')
        }
    },
    methods: {
        autoHeight() {
            document.getElementById('task_' + this.id).style.height
                = (document.getElementById('task_' + this.id).scrollHeight)+"px";
        }
    },
    mounted() {
        this.autoHeight();
    }
}
</script>
