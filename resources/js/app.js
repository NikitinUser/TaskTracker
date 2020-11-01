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
  	mounted() {
    	if (localStorage.getItem('tasks')) {
	      	try {
	        	this.tasks = JSON.parse(localStorage.getItem('tasks'));
	      	} catch(e) {
	       		localStorage.removeItem('tasks');
	      	}
	      	//this.tasks = localStorage.tasks;
    	}
  	},
  	/*
  	watch: {
    	tasks(newTask) {
      	localStorage.tasks.push(newTask);// = newName;
    	}
  	},*/
  	flag_rewrite: false,
});
