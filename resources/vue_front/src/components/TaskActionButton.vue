<template>
    <div class="me-2">
        <button class="pull-right btn btn-outline-success w-100 li-main-action"
            v-bind:id="idTask" v-on:click="taskDone">
            <i class="fa fa-check-square li-i-main-action"></i>
        </button>
    </div>
</template>

<script>
export default {
    name: 'TaskActionButton',
    props: ['buttonColor', 'buttonIcon', 'action', 'idTask'],
    data() {
        return {
            
        }
    },
    methods: {
        taskDone () {
            let storage = localStorage.getItem('tasks');

            if (storage == null) {
                storage = [];
            } else {
                try {
                    storage = JSON.parse(storage);
                } catch (ex) {
                    storage = [];
                }
            }

            let newStorage = [];
            for (let i=0; i < storage.length; i++) {
                if (storage[i].id != this.idTask) {
                    newStorage.push(storage[i]);
                }
            }

            this.$parent.$parent.tasks = newStorage;
            storage = JSON.stringify(newStorage);

            localStorage.setItem('tasks', storage);
        }
    }
}
</script>
