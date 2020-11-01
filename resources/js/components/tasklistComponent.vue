<template id="task-list">
    <section class="tasks ">
        <div class="input-group mb-3">
            <input type="text" placeholder="Задача" class="form-control" v-model="newTask" @keyup.enter ="addTask" size="100">  
            <span class="input-group-append">
                <button class="btn btn-primary" @click="addTask">
                    <i class="fa fa-plus"></i> 
                </button>
            </span>
        </div>
        <ul class="list-group">
            <task-item  v-for="(task, index) in tasks" @remove="removeTask(index)" @complete="completeTask(task)" :task="task" :key ="task.id"></task-item>
        </ul>
    </section>
</template>

<script>
    export default {
        template: '#task-list',
          props: {
            tasks: {default: []}
          },
          data() {
            return {
              newTask: ''
            };
          },
          methods: {
            addTask() {
              if (this.newTask) {
                this.tasks.push({
                  title: this.newTask,
                  completed: false
                });
                this.newTask = '';
                const parsed = JSON.stringify(this.tasks);
                localStorage.setItem('tasks', parsed);
              }
            },
            completeTask(task) {
              task.completed = ! task.completed;
            },
            removeTask(index) {
              this.tasks.splice(index, 1);
              const parsed = JSON.stringify(this.tasks);
              localStorage.setItem('tasks', parsed);
            }
          }
    }
</script>
