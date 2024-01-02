<template>
    <div :class="taskClass">
        <div class="flex-container-row">
            <div class="task-date">
                {{ task?.createdAt }}
            </div>
            <div v-if="!child">
                <AddTaskModal
                    :parentTask="task?.id"
                    @addTask="addTask"
                />
            </div>
            <div>
                <button class="btn-sm btn-success" @click="doneTask">v</button>
            </div>
        </div>
        
        <textarea class="task-text"
            v-text="task?.task"
            @input="changeTaskText($event.target.value)"
            @change="changeTaskText($event.target.value)"
        ></textarea>

        <div v-if="!child">
            <button class="btn-sm" @click="clickShowChildren">{{ showChildrenBtnText }}</button>
            <div v-if="showChildren">
                <Task v-for="childTask in task?.children"
                    :task="childTask"
                    :child="true"
                    @deleteTask="deleteTask"
                    @updateTask="updateTask"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import AddTaskModal from '../components/AddTaskModal.vue'

export default defineComponent({
    name: 'Task',
    components: {
        AddTaskModal
    },
    props: {
        task: Object,
        child: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            showChildren: false,
            showChildrenBtnText: 'Show'
        }
    },
    computed: {
        taskClass() {
            return this.child ? 'task-card-child' : 'task-card';
        }
    },
    emits: [
        "addTask",
        "deleteTask",
        "updateTask"
    ],
    methods: {
        clickShowChildren() {
            this.showChildren = !this.showChildren;
            this.showChildrenBtnText = this.showChildren ? 'Hide' : 'Show';
        },
        addTask(task: any) {
            this.$emit('addTask', task);
        },
        doneTask() {
            this.$emit('deleteTask', this.task);
        },
        deleteTask(task: any) {
            this.$emit('deleteTask', task);
        },
        changeTaskText(newTaskText: string) {
            this.task.task = newTaskText;
            this.$emit('updateTask', this.task);
        },
        updateTask(task: any) {
            this.$emit('updateTask', task);
        }
    }
})
</script>

<style scoped>
.task-card {
    background-color: #242424;
    border-radius: 5px;
    border: 1px solid transparent;
    border-color: rgb(0, 0, 0);
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 10px;
    margin-right: 10px;
    max-width: 250px;
    min-width: 250px;
}

.task-card-child {
    background-color: #242424;
    border-radius: 5px;
    border: 1px solid transparent;
    border-color: rgb(0, 0, 0);
    border-radius: 10px;
    padding: 10px;
}
.task-date {
    font-size: 12px;
    color: #ffffff;
}

.task-text {
    font-size: 16px;
    color: #ffffff;
    width: 97%;
    text-align: left;
}

.add-children-btn {
    margin-top: 10px;
}
</style>
