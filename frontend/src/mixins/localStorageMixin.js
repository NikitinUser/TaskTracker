export default {
    methods: {
        getTasksFromLocalStorage() {
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
    }
}
