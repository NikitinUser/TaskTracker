<template>
  <div id="app" class="row justify-content-center bg-dark-theme">
    <div class="col-md-7 bg-dark-theme">
      <TaskInput v-if="showInput"></TaskInput>

      <ul id="task-list" class="list-group list-group-flush">
        <li class="list-group-item list-group-item-darktheme border border-dark"
          v-for="task in tasks" v-bind:key="task.id">
          <TaskItem
            :task="task.task"
            :priority="task.priority"
            :type="task.type"
            :date="task.date"
            :id="task.id"
            :theme="task.theme"
          ></TaskItem>
        </li>
      </ul>

      <LoadingSpinner v-show="showLoadingSpinner"></LoadingSpinner>

      <datalist id="suggestions-themes">
        <option v-for="theme in suggestionsThemes" v-bind:key="theme.theme">
          {{ theme.theme ?? 'Без темы' }}
        </option>
      </datalist>
    </div>
  </div>
</template>

<script>
import TaskInput from './components/TaskInput.vue'
import TaskItem from './components/TaskItem.vue'
import LoadingSpinner from './components/LoadingSpinner.vue'

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
  data() {
    return {
      tasks: [],
      currentRoute: window.location.pathname,
      suggestionsThemes: [],
      showLoadingSpinner: false,
      showInput: true
    }
  },
  methods: {
    loadTasks (typeRequest) {
        let requestRoute = '/get_tasks' + "?type=" + typeRequest;

        var aThis = this;
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
                    taskData.priority = data[i].priority;
                    taskData.type = typeRequest;
                    taskData.theme = data[i].theme;
                    this.tasks.push(taskData);
                }
            });
        } catch (ex) {
            aThis.showLoadingSpinner = false;
            console.log(ex);
        }
    },
    getTasksThemes () {
      var vThis = this;
      fetch('get_tasks_themes', {
        method: 'GET'
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
          vThis.suggestionsThemes = data;
      });
    },
    getTasksFromLocalStorage () {
      let tasksFromStorage = localStorage.getItem('tasks');
      if (tasksFromStorage == null) {
          tasksFromStorage = [];
      } else {
          try {
              tasksFromStorage = JSON.parse(tasksFromStorage);
          } catch (ex) {
              tasksFromStorage = [];
          }
      }

      return tasksFromStorage;
    }
  },
  mounted() {
    if (this.currentRoute == "/demo") {
      let tasksFromLocal = this.getTasksFromLocalStorage();
      this.tasks = tasksFromLocal;
    } else {
      this.loadTasks(typesTasks[this.currentRoute]);
      this.getTasksThemes();
    }
    
    this.showInput = this.currentRoute != '/done' && this.currentRoute != '/archive';
  },
  flag_rewrite: false,
}
</script>
