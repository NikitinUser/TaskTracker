<template id="task-item" class="row">
    <li class="list-group-item">
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <button :class="className" @click.self="$emit('complete')">
                    {{ task.title }}
                </button>
                <button class="pull-right btn btn-outline-danger btn-sm col-md-1 col-sm-1" @click="$emit('remove')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
                                
        </div>
                            
    </li>
</template>


<script>
    export default {
        template: '#task-item',
          props: ['task'],
          computed: {
            className() {
              let classes = ['btn btn-secondary btn-sm col-md-11 col-sm-11'];
              if (this.task.completed) {
                classes.push('btn btn-success btn-sm col-md-11 col-sm-11');
              }
              return classes.join(' ');
            }
          }
    }
</script>
