<template>
  <div id="app" class="container bg-dark-theme">
    <div class="row justify-content-center bg-dark-theme">
      <div class="col-md-9 bg-dark-theme">
        <div class="card-body task-input" id="">
          <TaskInput></TaskInput>

          <ul id="task-list" class="list-group list-group-flush bg-dark-tasks-theme">
            <li class="list-group-item list-group-item-darktheme border border-dark"
              v-for="task in tasks" v-bind:key="task.id">
              <TaskItem
                :task="task.task"
                :priority="task.priority"
                :type="task.type"
                :date="task.date"
                :id="task.id"
              ></TaskItem>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TaskInput from './components/TaskInput.vue'
import TaskItem from './components/TaskItem.vue'

export default {
  name: 'App',
  components: {
    TaskInput,
    TaskItem
  },
  data() {
    return {
      tasks: []
    }
  },
  mounted() {
    if (localStorage.getItem('tasks')) {
      try {
        this.tasks = JSON.parse(localStorage.getItem('tasks'));
      } catch(e) {
        localStorage.removeItem('tasks');
      }
    }
  },
  flag_rewrite: false,
}
</script>

<style>

</style>
