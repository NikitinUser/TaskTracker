<template>
    <button class="btn-sm" @click="switchShowModal">+</button>

    <div v-if="showModal" class="modal">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <textarea v-model="task" class="simple-text-input" placeholder="Задача"></textarea>
                </div>
                <div v-if="parentTask !== null">
                    <input v-model="parentTask" class="simple-text-input" readonly/>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" @click="switchShowModal">Отмена</button>
                <button class="btn" @click="addTask">Добавить</button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'AddTaskModal',
    props: {
        parentTask: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            task: '',
            showModal: false
        }
    },
    emits: ["addTask"],
    methods: {
        addTask() {
            this.$emit('addTask', {
                task: this.task,
                parentTask: this.parentTask
            });
            this.switchShowModal();
            this.task = '';
        },
        switchShowModal() {
            this.showModal = !this.showModal;
        }
    }
})
</script>

<style scoped>
.modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-y: scroll;
}

.modal-content {
    margin-top: 10px;
    background-color: #3d43c1;
    padding: 20px;
    min-width: 20%;
}

.modal-body {
    margin-bottom: 40px;
}

.modal-footer {
    display: flex;
    justify-content: space-between;
}

.simple-text-input {
    border-bottom: 2px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    margin: 5px;
}
</style>
