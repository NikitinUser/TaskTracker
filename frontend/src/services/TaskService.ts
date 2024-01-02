import { LocalTasks } from "./LocalTasks";
import { ServerTasks } from "./ServerTasks";

export class TaskService {

    private localTasks: LocalTasks;
    private serverTasks: ServerTasks;

    constructor() {
        this.localTasks = new LocalTasks();
        this.serverTasks = new ServerTasks();
    }

    public async getTasks(isDemoMode: boolean): Promise<any[]> {
        if (isDemoMode) {
            return this.localTasks.getTasks();
        } else {
            return await this.serverTasks.getTasks();
        }
    }

    public async addTask(task: any, isDemoMode: boolean) {
        if (isDemoMode) {
            this.localTasks.addTask(task);
        } else {
            await this.serverTasks.addTask(task);
        }
    }

    public async deleteTask(task: any, isDemoMode: boolean) {
        if (isDemoMode) {
            this.localTasks.deleteTask(task);
        } else {
            await this.serverTasks.deleteTask(task);
        }
    }

    public updateTask(task: any, isDemoMode: boolean) {
        if (isDemoMode) {
            this.localTasks.updateTask(task);
        } else {
            this.serverTasks.updateTask(task);
        }
    }
}
