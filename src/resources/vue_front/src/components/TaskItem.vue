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

            <div class="text-white mb-2" v-show="visibleTask">
                <span :id="'count_task_' + id" class="text-white" style="font-size: small">{{currentSymbolsTask}}/2100</span>
                <textarea type="text" :id="'task_' + id" placeholder="Задача"
                    size="100" maxlength="2100" class="form-control bg-dark-theme"
                    v-on:input="inputTask($event); autoHeight($event)"
                    v-on:blur="autoHeight" v-on:focus="autoHeight" :value="task"
                    :readonly="readonlyInput"
                ></textarea>
            </div>
        </div>
    </div>
</template>

<script>
import TaskActionButton from './TaskActionButton.vue';
import dateTimeMixin from './../mixins/dateTimeMixin';

export default {
    name: 'TaskItem',
    components: {
        TaskActionButton
    },
    mixins: [dateTimeMixin],
    props: ['task', 'type', 'date', 'id'],
    data() {
        return {
            visibleTask: true,
            visibleModalChange: false,
            currentRoute: window.location.pathname,
            token: document.querySelector('meta[name=csrf-token').getAttribute('content'),
            currentSymbolsTask: 0,
            maxSymbolsTask: 2100,
            readonlyInput: false
        }
    },
    methods: {
        inputTask(event) {
            // eslint-disable-next-line
            this.task = event.target.value;
            this.currentSymbolsTask = event.target.value.length;
            this.updateTask();
        },
        getCurrentSymbolsInInput() {
            this.currentSymbolsTask = this.task.length;
        },
        autoHeight(event) {
            event.target.style.height = "60px";
            event.target.style.height = (event.target.scrollHeight)+"px";
        },
        updateTask() {
            // eslint-disable-next-line
            this.date = this.getDateTime();
            let params = "task=" + this.task + "&id=" + this.id + "&date=" + this.date + "&type=" + this.type;

            try {
                fetch('/tasks', {
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
                    if (data?.errors != null) {
                        alert(data.errors?.task);
                    }
                });
            } catch (ex) {
                console.log(ex);
            }
        }
    },
    mounted() {
        this.getCurrentSymbolsInInput();
        if (window.location.pathname == '/demo' && this.inputId != "newTask") {
            this.readonlyInput = true;
        }
    }
}
</script>
