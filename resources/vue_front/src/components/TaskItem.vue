<template>
    <div id="li-div_{{ id }}" style="min-height: 200px;">
        <div class="d-flex flex-row" style="min-height: 150px;">
            <div class="text-white d-flex flex-column" style="max-width: 20%">
                <div class="mb-3">
                    <label class="task-theme" v-bind:id="id"></label>
                </div>

                <div class="mb-3 d-flex flex-column">
                    <em class="li-date" style="font-size: small"></em>
                    <em class="li-date-time" style="font-size: small"></em>
                </div>

                <div>
                    <button type="button" class="btn btn-outline-light btn-sm li-btn-hid"
                        v-on:click="visibleTask=!visibleTask">
                        {{visibleTask?'Скрыть':'Показать'}}
                    </button>
                </div>
            </div>

            <div class="text-white flex-fill ms-3 me-1">
                <span v-bind:id="id" class="li-text-task" v-show="visibleTask">
                    {{ task }}
                    <i class="li-i-priority ms-1"></i>
                </span>
                <input v-bind:id="id" type="hidden" class="li-priority-id" v-bind:value="priority">
            </div>
        </div>

        <div class="text-white d-flex flex-row pull-right">
            <TaskActionButton
                :idTask="id"
            ></TaskActionButton>
        </div>
    </div>
</template>

<script>
import TaskActionButton from './TaskActionButton.vue'

export default {
    name: 'TaskItem',
    components: {
        TaskActionButton
    },
    props: ['task', 'priority', 'type', 'date', 'id'],
    data() {
        return {
            visibleTask: true
        }
    },
}
</script>

<style scoped>

</style>
