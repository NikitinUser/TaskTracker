import config from './../../config';

export class ServerTasks {
    private token: string|null;
    private url: string;

    constructor() {
        this.token = localStorage.getItem('token');
        this.url = config.apiUrl;
    }

    public async getTasks(): Promise<any[]> {
        const response = await fetch(this.url + 'api/task', {
            method: 'GET',
            headers: new Headers({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.token}`
            })
        });

        const result = await response.json();
        const tasks = result?.data?.tasks ?? [];

        return tasks;
    }

    public async addTask(task: any) {
        await fetch(this.url + 'api/task', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.token}`
            }), 
            body: JSON.stringify({
                'task': task.task,
                'parentTask': task.parentTask
            })
        }).catch((error) => {
            console.log(error);
        });
    }

    public async deleteTask(task: any) {
        await fetch(this.url + 'api/task/' + task.id, {
            method: 'DELETE',
            headers: new Headers({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.token}`
            })
        }).catch((error) => {
            console.log(error);
        });
    }

    public async updateTask(task: any) {
        await fetch(this.url + 'api/task/update', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.token}`
            }), 
            body: JSON.stringify({
                'id': task.id,
                'task': task.task,
                'parentTask': task.parentTask
            })
        }).catch((error) => {
            console.log(error);
        });
    }
}
