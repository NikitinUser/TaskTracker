
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div id="app">
                      <task-list :tasks="tasks"></task-list>
                    </div>
                    <template id="task-list">
                      <section class="tasks ">
                        <div class="input-group mb-3">
                          <input type="text" placeholder="Задача" class="form-control" v-model="newTask" @keyup.enter ="addTask" size="100">  
                          <span class="input-group-append">
                            <button class="btn btn-primary" @click="addTask">
                              <i class="fa fa-plus"></i> 
                            </button>
                          </span>
                        </div>
                        <ul class="list-group">
                          <task-item  v-for="(task, index) in tasks" @remove="removeTask(index)" @complete="completeTask(task)" :task="task" :key ="task.id"></task-item>
                        </ul>
                      </section>
                    </template>
                    <template id="task-item" class="row">
                        <li class="list-group-item">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    <button :class="className" @click.self="$emit('complete')">
                                      @{{ task.title }}
                                    </button>
                                    <button class="pull-right btn btn-outline-danger btn-sm col-md-1 col-sm-1" @click="$emit('remove')">
                                      <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                
                            </div>
                            
                        </li>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
        

@endsection