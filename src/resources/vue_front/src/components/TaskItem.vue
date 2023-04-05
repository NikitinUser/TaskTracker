<template>
    <div v-bind:id="id" style="min-height: 200px;">
        <div>
            <div class="d-flex flex-row mb-3" style="min-height: 150px;">
                <div class="text-white d-flex flex-column" style="max-width: 20%">
                    <div class="mb-3 d-flex flex-column">
                        <em style="font-size: small">
                            {{ date.split(" ")[0] }}
                        </em>
                        <em style="font-size: small">
                            {{ date.split(" ")[1] }}
                        </em>
                    </div>

                    <div>
                        <button type="button" class="btn btn-outline-light btn-sm"
                            v-on:click="visibleTask=!visibleTask">
                            {{visibleTask?'Скрыть':'Показать'}}
                        </button>
                    </div>
                </div>

                <div class="text-white d-flex justify-content-center w-100 ms-3 me-1">
                    <span v-bind:id="id" v-show="visibleTask">
                        {{ task }}
                    </span>
                </div>
            </div>

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
