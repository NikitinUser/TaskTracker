/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('task-list', require('./components/tasklistComponent.vue').default);
Vue.component('task-item', require('./components/taskitemComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
	    tasks: []
	  },
    flag_rewrite: false,
    watch: {
      tasks: { 

        handler: function (newVal) {
          
          if (this.flag_rewrite){
            axios({
              method: 'post',
              url: '/home/tasks_ajax',
              data: {
                action: 'set-storage',
                'data-storage': JSON.stringify(newVal[newVal.length - 1])
              }
            })
            .then(function (response) {
              if (response.data == 'error'){
                console.log('error Ошибка: не удалось сохранить данные');
              }else{
                console.log(response.data);
              }
            })
            .catch(function (){
              console.log('catch Ошибка: не удалось сохранить данные');
            })
          }
          if (!this.flag_rewrite) this.flag_rewrite = true;
        },
        deep: true
      }  
    },
  	flag_rewrite: false,
});
document.addEventListener('DOMContentLoaded', function(){
      axios({
        method: 'post',
        url: '/home/tasks_ajax',
        data: {
          action: 'get-storage'
        }
      })
      .then(function (response) {
        data = response.data;
        if (data != 'error'){
          app.tasks = data;
        } else {
            console.log('error Ошибка: не удалось загрузить данные');
        }
      })
      .catch (function (){
        console.log('catch Ошибка: не удалось загрузить данные');
      })
    });
