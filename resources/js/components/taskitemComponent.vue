<template id="task-item">
        <li class="list-group-item">
            <div class="row">
                <div class=" col-md-1 col-sm-1">
                    <input class="pull-left" type="checkbox">
                </div>
                <div class="col-md-10 col-sm-10 text-center">
                    {{ task.task }}
                </div>
                <div class="col-md-1 col-sm-1"> 
                    <button class="pull-right btn btn-outline-danger btn-sm " @click="$emit('remove')">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>                           
        </li>
</template>


<script>
    export default {
        template: '#task-item',
          props: ['task'],
    }
    
</script>
