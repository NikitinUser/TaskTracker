<template>
  <div id="app" class="container bg-dark-theme">
    <div class="row justify-content-center bg-dark-theme">
      <div class="col-md-9 bg-dark-theme">
        <div class="card-body task-input" id="">
          <TaskInput
            v-if="
              this.currentRoute != 'done'
              && this.currentRoute != 'archive'
            "
          ></TaskInput>

          <ul id="task-list" class="list-group list-group-flush bg-dark-tasks-theme">
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
              {{theme.theme ?? 'Без темы'}}
            </option>
          </datalist>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TaskInput from './components/TaskInput.vue'
import TaskItem from './components/TaskItem.vue'
import LoadingSpinner from './components/LoadingSpinner.vue'

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
      currentRoute: window.location.href.split("/")[3],
      suggestionsThemes: [],
      showLoadingSpinner: false
    }
  },
  methods: {
    loadTasks (typeRequest) {
        let route = '/get_tasks';
        route += "?type=" + typeRequest;
        this.type = typeRequest;

        var aThis = this;
        aThis.showLoadingSpinner = true;
 
        try {
            fetch(route)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                aThis.showLoadingSpinner = false;
                this.tasks = [];
                for (let i = 0; i < data.length; i++) {
                    let taskData = {};
                    taskData.id = data[i].id;
                    taskData.date = data[i].dt_task;
                    taskData.task = data[i].task;
                    taskData.priority = data[i].priority;
                    taskData.type = this.type;
                    taskData.theme = data[i].theme;
                    this.tasks.push(taskData);
                }
            });
        } catch (ex) {
            aThis.showLoadingSpinner = false;
            console.log(ex);
        }
    },
    getTasksThemes() {
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
    }
  },
  mounted() {
    if (this.currentRoute == "demo") {
      if (localStorage.getItem('tasks')) {
        try {
          this.tasks = JSON.parse(localStorage.getItem('tasks'));
        } catch(e) {
          localStorage.removeItem('tasks');
        }
      }
    } else {
      let type = 0;

      if (this.currentRoute == "done") {
        type = 1;
      } else if (this.currentRoute == "bookmarks") {
        type = 3;
      } else if (this.currentRoute == "archive") {
        type = 2;
      }

      this.loadTasks(type);
      this.getTasksThemes();
    }
    
  },
  flag_rewrite: false,
}
</script>

<style>

</style>
