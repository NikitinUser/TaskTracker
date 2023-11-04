<template>
  <div id="app" class="row justify-content-center bg-dark-theme">
    <div class="col-md-7 bg-dark-theme">
      <TaskInput
        v-if="showInput"
        :currentRoute="currentRoute"
        v-on:callShowLoadingSpinner="callShowLoadingSpinner"
        v-on:callPushTask="callPushTask"
    ></TaskInput>

      <div class="p-2">
        <ul id="task-list" class="list-group list-group-flush">
          <li class="list-group-item list-group-item-darktheme border border-dark"
            v-for="task in tasks" v-bind:key="task.id">
            <TaskItem
              :task="task.task"
              :type="task.type"
              :date="task.date"
              :id="task.id"

              v-on:callShowLoadingSpinner="callShowLoadingSpinner"
            ></TaskItem>
          </li>
        </ul>
      </div>

      <LoadingSpinner v-show="showLoadingSpinner"></LoadingSpinner>
    </div>
  </div>
</template>

<script>
import TaskInput from './components/TaskInput.vue'
import TaskItem from './components/TaskItem.vue'
import LoadingSpinner from './components/LoadingSpinner.vue'
import localStorageMixin from './mixins/localStorageMixin';

const typesTasks = {
    "/": 0,
    "/home": 0,
    "/done": 1,
    "/archive": 2,
    "/bookmarks": 3,
}

export default {
    name: 'App',
    components: {
        TaskInput,
        TaskItem,
        LoadingSpinner
    },
    mixins: [localStorageMixin],
    data() {
        return {
          tasks: [],
          currentRoute: window.location.pathname,
          showLoadingSpinner: false,
          showInput: true
        }
    },
    methods: {
        loadTasks (typeRequest) {
            let requestRoute = '/tasks?' + 'type=' + typeRequest;

            let aThis = this;
            aThis.showLoadingSpinner = true;

            try {
                fetch(requestRoute)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    aThis.showLoadingSpinner = false;

                    for (let i = 0; i < data.length; i++) {
                        let taskData = {};
                        taskData.id = data[i].id;
                        taskData.date = data[i].dt_task;
                        taskData.task = data[i].task;
                        taskData.type = typeRequest;
                        this.tasks.push(taskData);
                    }
                });
            } catch (ex) {
                aThis.showLoadingSpinner = false;
                console.log(ex);
            }
        },
        callShowLoadingSpinner(show) {
            this.showLoadingSpinner = show;
        },
        callPushTask(task) {
            this.tasks.push(task);
        }
    },
    mounted() {
        if (this.currentRoute == "/demo") {
            let tasksFromLocal = this.getTasksFromLocalStorage();
            this.tasks = tasksFromLocal;
        } else {
            this.loadTasks(typesTasks[this.currentRoute]);
        }
    
        this.showInput = this.currentRoute != '/done' && this.currentRoute != '/archive';
    }
}
</script>
