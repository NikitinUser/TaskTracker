export class LocalTasks {
    public getTasks(): any[] {
        let tasks = localStorage.getItem('tasks') ?? JSON.stringify([]);

        return JSON.parse(tasks);
    }

    public addTask(task: any) {
        let tasks = this.getTasks();

        task.id = +new Date;
        task.createdAt = task.id;

        task.children = [];

        if (task.parentTask === null) {
            tasks.push(task);
        } else {
            tasks = tasks.map((t: any) => {
                if (t.id == task.parentTask) {
                    t.children.push(task);
                }

                return t;
            });
        }

        localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    public deleteTask(task: any) {
        let tasks = this.getTasks();

        if (task.parentTask === null) {
            if (task.children.length > 0) {
                task.children.forEach((c: any) => {
                    c.parentTask = null;
                    tasks.push(c);
                });
            }

            tasks = tasks.filter((t: any) => t.id !== task.id);
        } else {
            tasks = tasks.map((t: any) => {
                if (t.id == task.parentTask) {
                    t.children = t.children.filter((c: any) => c.id !== task.id);
                }

                return t;
            });
        }

        localStorage.setItem('tasks', JSON.stringify(tasks));
    }

    public updateTask(task: any) {
        let tasks = this.getTasks();

        if (task.parentTask === null) {
            tasks = tasks.map((t: any) => {
                if (t.id == task.id) {
                    t.task = task.task;
                }

                return t;
            });
        } else {
            tasks = tasks.map((t: any) => {
                if (t.id == task.parentTask) {
                    t.children = t.children.map((c: any) => {
                        if (c.id == task.id) {
                            c.task = task.task;
                        }

                        return c;
                    });
                }

                return t;
            });
        }

        localStorage.setItem('tasks', JSON.stringify(tasks));
    }
}
