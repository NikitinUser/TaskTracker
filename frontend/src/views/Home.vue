<template>
    <div class="flex-container">
		<SwitchMode
			:isLocal="isLocal"
			@update:isLocal="isLocal = $event"
			@getTasks="getTasks"
		/>
		<div>
			<AddTaskModal
				@addTask="addTask"
			/>
		</div>
	</div>
	<div class="tasks">
		<Task v-for="task in tasks"
			:task="task"
			@addTask="addTask"
			@deleteTask="deleteTask"
			@updateTask="updateTask"
		/>
	</div>
</template>

<script lang="ts">
import { TaskService } from '../services/TaskService'
import { AuthService } from '../services/AuthService';
import { defineComponent } from 'vue'
import AddTaskModal from '../components/AddTaskModal.vue'
import Task from '../components/Task.vue'
import SwitchMode from '../components/SwitchMode.vue'

export default defineComponent({
	name: 'Home',
	components: {
		AddTaskModal,
		TaskService,
		Task,
		SwitchMode
	},
	data() {
		return {
			tasks: [] as Array<any>,
			isLocal: true,
			taskService: new TaskService(),
			authService: new AuthService()
		}
	},
	emits: [
		"loadingStart",
		"loadingStop"
	],
	methods: {
		async getTasks() {
			this.$emit('loadingStart');

			if (!this.isLocal) {
				const isLoggedIn = await this.authService.isLoggedIn();
				if (!isLoggedIn) {
					this.$router.push('/login');
					return;
				}
			}

			const tasks = await this.taskService.getTasks(this.isLocal);

			this.$emit('loadingStop');

			this.tasks = tasks;
		},
		async addTask(task: any) {
			this.$emit('loadingStart');

			await this.taskService.addTask(task, this.isLocal);

			this.$emit('loadingStop');

			this.getTasks();
		},
		async deleteTask(task: any) {
			this.$emit('loadingStart');

			await this.taskService.deleteTask(task, this.isLocal);

			this.$emit('loadingStop');

			this.getTasks();
		},
		updateTask(task: any) {
			this.$emit('loadingStart');

			this.taskService.updateTask(task, this.isLocal);

			this.$emit('loadingStop');
		}
	},
	mounted() {
		this.getTasks();
	}
})

</script>

<style scoped>
.tasks {
	display: flex;
	flex-wrap: wrap;
	justify-content: flex-start;
	align-items: flex-start;
	margin-top: 25px;
}
</style>
