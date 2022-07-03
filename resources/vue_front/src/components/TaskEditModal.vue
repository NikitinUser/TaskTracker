<template>
<div class="modal-mask" tabindex="-1">
    <div class="modal-wrapper text-white">
        <div>
            <div class="modal-header bg-dark-theme">
                <h5 class="modal-title">Редактирование</h5>
            </div>
            <div class="modal-body bg-dark-theme">
                <div class="mb-2">
                    <label>Текст:</label>
                    <textarea class="form-control" rows="3" v-bind:value="task"
                        v-on:input="changeTaskText"></textarea>
                </div>
                
                <div class="mb-2">
                    <label>Приоритетность:</label>
                    <select class="form-select" v-bind:value="priority"
                        v-on:change="changePriority">
                        <option value="0"> Low </option>
                        <option value="1"> Middle</option>
                        <option value="2"> High</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label>Тема задачи:</label>
                    <input type="text" name="theme" class="form-control" list="suggestions-themes">
                </div>
            </div>
            <div class="modal-footer bg-dark-theme">
                <button type="button" class="btn btn-secondary" v-on:click="hideModal">Закрыть</button>
                <button type="button" class="btn btn-primary" v-on:click="changeTask">Сохранить</button>
            </div>
        </div>
    </div>
</div>   
</template>

<script>
export default {
    name: 'TaskEditModal',
    props: ['task', 'priority', 'id', 'theme'],
    data() {
        return {
            token: document.querySelector('meta[name=csrf-token').getAttribute('content'),
            changedTask: "",
            changedPriority: "",
        }
    },
    methods: {
        changeTaskText (event) {
            this.changedTask = event.target.value;
        },
        changePriority (event) {
            this.changedPriority = event.target.value;
        },
        hideModal () {
            this.$parent.visibleModalChange = false;
        },
        changeTask () {
            //var modal = new bootstrap.Modal(document.getElementById('modalWaitingServer'));
            //modal.show();
            let params = "task=" + this.changedTask + "&priorityTask="
                + this.changedPriority + "&id=" + this.id + "&theme=" + this.theme;

            try {
                fetch('changeTask', {
                method: 'POST',
                headers: new Headers({
                    'Content-Type': 'application/x-www-form-urlencoded',
                    "X-CSRF-TOKEN": this.token
                }), 
                body: params,
                })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    //modal.hide();

                    if (data?.errors != null) {
                        alert(data.errors?.task);
                        return false;
                    }

                    location.reload();
                });
            } catch (ex) {
                //modal.hide();
            }
        }
    }
}
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}
.modal-wrapper {
  display: flex;
  align-items: center;
  justify-content: center
}
</style>
