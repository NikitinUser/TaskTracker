<template>
    <div v-bind:id="id">
        <div>
            <div class="text-white mb-3">
                <em style="font-size: small">{{ date }}</em>

                <button type="button" class="btn btn-outline-light ms-2"
                    v-on:click="visibleTask=!visibleTask">
                    <i v-if="visibleTask" class="fa fa-eye-slash" aria-hidden="true"></i>
                    <i v-else class="fa fa-eye" aria-hidden="true"></i>
                </button>

                <div class="text-white d-flex flex-row pull-right"
                    v-if="currentRoute == '/demo'">
                    <TaskActionButton
                        buttonIcon = "fa fa-check-square"
                        buttonClass = "pull-right btn btn-outline-success w-100"
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
                        buttonClass = "pull-right btn btn-outline-success w-100"
                        action = "swapTaskToDone"
                        :idTask="id"
                        :changedTask="task"
                        :type="type"
                    ></TaskActionButton>

                    <TaskActionButton
                        v-else
                        buttonIcon = "fa fa-trash"
                        buttonClass = "pull-right btn btn-outline-danger w-100"
                        action = "deleteTask"
                        :idTask="id"
                        :changedTask="task"
                        :type="type"
                    ></TaskActionButton>

                    <TaskActionButton
                        buttonIcon = "fa fa-location-arrow"
                        buttonClass = "pull-right btn btn-outline-success w-100"
                        action = "swapTaskToTasks"
                        :idTask="id"
                        :changedTask="task"
                        :type="type"
                    ></TaskActionButton>

                    <TaskActionButton
                        buttonIcon = "fa fa-bookmark"
                        buttonClass = "pull-right btn btn-outline-primary w-100"
                        action = "swapTaskToBookmarks"
                        :idTask="id"
                        :changedTask="task"
                        :type="type"
                    ></TaskActionButton>

                    <TaskActionButton
                        buttonIcon = "fa fa-archive"
                        buttonClass = "pull-right btn btn-outline-info w-100"
                        action = "swapTaskToArchive"
                        :idTask="id"
                        :changedTask="task"
                        :type="type"
                    ></TaskActionButton>

                    <TaskActionButton
                        buttonIcon = "fa fa-pencil-square"
                        buttonClass = "pull-right btn btn-outline-warning w-100"
                        action = "editTask"
                        :idTask="id"
                    ></TaskActionButton>
                </div>
            </div>

            <div class="text-white mb-2">
                <textarea v-bind:id="id" v-show="visibleTask" class="form-control"
                    :value="task" readonly></textarea>
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
    }
}
</script>
