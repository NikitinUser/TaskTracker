<template>
    <div class="toggle-switch">
        <div :class="{ 'active': isLocal }" @click="toggleSwitch(true)">Локально</div>
        <div :class="{ 'active': !isLocal }" @click="toggleSwitch(false)">Сервер</div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'SwitchMode',
    props: {
        isLocal: Boolean,
    },
    methods: {
        toggleSwitch(isLocal: boolean) {
            if (this.isLocal !== isLocal) {
                this.$emit('update:isLocal', isLocal);
                this.$emit('getTasks');
            }
        },
    },
});
</script>

<style scoped>
.toggle-switch {
    display: flex;
    justify-content: space-between;
    width: 200px;
    background-color: #878787;
    border-radius: 20px;
    overflow: hidden;
}

.toggle-switch div {
    flex: 1;
    text-align: center;
    padding: 10px;
    cursor: pointer;
    user-select: none;
}

.toggle-switch div.active {
    background-color: #535bf2;
    color: white;
}
</style>
