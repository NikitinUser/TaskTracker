(function(){"use strict";var t={6718:function(t,e,a){var s=a(6369),n=function(){var t=this,e=t._self._c;return e("div",{staticClass:"row justify-content-center bg-dark-theme",attrs:{id:"app"}},[e("div",{staticClass:"col-md-7 bg-dark-theme"},[t.showInput?e("TaskInput"):t._e(),e("div",{staticClass:"p-2"},[e("ul",{staticClass:"list-group list-group-flush",attrs:{id:"task-list"}},t._l(t.tasks,(function(t){return e("li",{key:t.id,staticClass:"list-group-item list-group-item-darktheme border border-dark"},[e("TaskItem",{attrs:{task:t.task,type:t.type,date:t.date,id:t.id}})],1)})),0)]),e("LoadingSpinner",{directives:[{name:"show",rawName:"v-show",value:t.showLoadingSpinner,expression:"showLoadingSpinner"}]})],1)])},i=[],o=function(){var t=this,e=t._self._c;return e("div",{staticClass:"p-2 bg-dark-theme",attrs:{id:"task-input"}},[e("span",{staticClass:"text-white",staticStyle:{"font-size":"small"},attrs:{id:"count_new_task"}},[t._v("0/2100")]),e("textarea",{staticClass:"form-control bg-dark-theme",attrs:{type:"text",name:"newTask",id:"newTask",placeholder:"Задача",size:"100",maxlength:"2100"},domProps:{value:t.task},on:{input:function(e){t.inputTask(e),t.autoHeight(e)}}}),e("div",{staticClass:"d-flex justify-content-center mt-1"},[e("button",{staticClass:"btn btn-secondary btn-lg rounded-circle",attrs:{id:"add_task_btn",type:"button"},on:{click:function(e){return t.addTask()}}},[e("i",{staticClass:"fa fa-plus"})])])])},r=[],l={methods:{getDateTime(){let t=new Date,e=String(t.getDate()).padStart(2,"0"),a=String(t.getMonth()+1).padStart(2,"0"),s=t.getFullYear(),n=t.getHours(),i=t.getMinutes(),o=t.getSeconds();return e+"-"+a+"-"+s+" "+n+":"+i+":"+o}}},c={name:"TaskInput",mixins:[l],data(){return{task:"",date:"",token:document.querySelector("meta[name=csrf-token").getAttribute("content")}},methods:{inputTask(t){this.task=t.target.value,document.getElementById("count_new_task").textContent=t.target.value.length+"/2100"},addTask(){if(this.date=this.getDateTime(),"/demo"==this.$parent.currentRoute)this.saveTaskToLocalStorage();else{let t=0;"/bookmarks"==this.$parent.currentRoute&&(t=3);let e="task="+this.task+"&date="+this.date+"&type="+t;this.saveTaskOnServer(e)}this.cleanInput()},saveTaskToLocalStorage(){let t=this.$parent.getTasksFromLocalStorage(),e={id:t.length+1+this.date,task:this.task,date:this.date};t.push(e),this.$parent.tasks=t,t=JSON.stringify(t),localStorage.setItem("tasks",t)},saveTaskOnServer(t){var e=this.$parent;e.showLoadingSpinner=!0;try{fetch("/tasks",{method:"POST",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:t}).then((t=>t.json())).then((t=>{if(e.showLoadingSpinner=!1,null!=t?.errors)return alert(t.errors?.task),!1;if(null==t.id)alert("Количество задач в этом списке стало равным 50. Это количество нельзя превышать, займись делом.");else{let e={};e.id=t.id,e.date=t.date,e.task=t.task,e.type=t.type,this.$parent.tasks.push(e)}}))}catch(a){console.log(a),e.showLoadingSpinner=!1}},cleanInput(){this.task="",this.date="",document.querySelector("#newTask").style.height="60px",document.getElementById("count_new_task").textContent="0/2100"},autoHeight(t){t.target.style.height="60px",t.target.style.height=t.target.scrollHeight+"px"}}},d=c,u=a(1001),h=(0,u.Z)(d,o,r,!1,null,null,null),k=h.exports,p=function(){var t=this,e=t._self._c;return e("div",{attrs:{id:t.id}},[e("div",[e("div",{staticClass:"text-white mb-3 row"},[e("div",{staticClass:"col-2"},[e("em",{staticStyle:{"font-size":"small"}},[t._v(t._s(t.date))])]),e("div",{staticClass:"col-10"},["/demo"==t.currentRoute?e("div",{staticClass:"text-white d-flex flex-row pull-right"},[e("TaskActionButton",{attrs:{buttonIcon:"fa fa-check-square",buttonClass:"pull-right btn btn-outline-success btn-sm w-100",action:"removeTaskFromLocal",idTask:t.id,changedTask:t.task,type:t.type}})],1):e("div",{staticClass:"text-white d-flex flex-row pull-right"},["/done"!=t.currentRoute?e("TaskActionButton",{attrs:{buttonIcon:"fa fa-check-square",buttonClass:"pull-right btn btn-outline-success btn-sm w-100",action:"swapTaskToDone",idTask:t.id,changedTask:t.task,type:t.type}}):e("TaskActionButton",{attrs:{buttonIcon:"fa fa-trash",buttonClass:"pull-right btn btn-outline-danger btn-sm w-100",action:"deleteTask",idTask:t.id,changedTask:t.task,type:t.type}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-location-arrow",buttonClass:"pull-right btn btn-outline-success btn-sm w-100",action:"swapTaskToTasks",idTask:t.id,changedTask:t.task,type:t.type}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-bookmark",buttonClass:"pull-right btn btn-outline-primary btn-sm w-100",action:"swapTaskToBookmarks",idTask:t.id,changedTask:t.task,type:t.type}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-archive",buttonClass:"pull-right btn btn-outline-info btn-sm w-100",action:"swapTaskToArchive",idTask:t.id,changedTask:t.task,type:t.type}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-pencil-square",buttonClass:"pull-right btn btn-outline-warning btn-sm w-100",action:"editTask",idTask:t.id}})],1),e("div",{staticClass:"text-white d-flex flex-row pull-right me-2"},[e("button",{staticClass:"btn btn-outline-light btn-sm",attrs:{type:"button"},on:{click:function(e){t.visibleTask=!t.visibleTask}}},[t.visibleTask?e("i",{staticClass:"fa fa-eye-slash",attrs:{"aria-hidden":"true"}}):e("i",{staticClass:"fa fa-eye",attrs:{"aria-hidden":"true"}})])])])]),e("div",{staticClass:"text-white mb-2"},[e("textarea",{directives:[{name:"show",rawName:"v-show",value:t.visibleTask,expression:"visibleTask"}],staticClass:"form-control",attrs:{id:"task_"+t.id,maxlength:"2100",readonly:""},domProps:{value:t.task}})])]),e("TaskEditModal",{directives:[{name:"show",rawName:"v-show",value:t.visibleModalChange,expression:"visibleModalChange"}],attrs:{id:t.id,task:t.task,type:t.type}})],1)},m=[],g=function(){var t=this,e=t._self._c;return e("div",{staticClass:"me-2"},[e("button",{class:t.buttonClass,attrs:{id:t.idTask},on:{click:t.taskBtnAction}},[e("i",{class:t.buttonIcon})])])},f=[],T={name:"TaskActionButton",props:["buttonClass","buttonIcon","action","idTask","changedTask","type"],mixins:[l],data(){return{token:document.querySelector("meta[name=csrf-token").getAttribute("content")}},methods:{taskBtnAction(){"removeTaskFromLocal"==this.action?this.removeTaskFromLocal():"swapTaskToDone"==this.action?this.taskSwapType(1):"deleteTask"==this.action?this.deleteTask():"swapTaskToTasks"==this.action?this.taskSwapType(0):"swapTaskToBookmarks"==this.action?this.taskSwapType(3):"swapTaskToArchive"==this.action?this.taskSwapType(2):"editTask"==this.action&&(this.$parent.visibleModalChange=!0)},removeTaskFromLocal(){let t=this.$parent.$parent.getTasksFromLocalStorage(),e=[];for(let a=0;a<t.length;a++)t[a].id!=this.idTask&&e.push(t[a]);this.$parent.$parent.tasks=e,t=JSON.stringify(e),localStorage.setItem("tasks",t)},taskSwapType(t){var e=this.$parent.$parent;e.showLoadingSpinner=!0;let a=this.getDateTime(),s="task="+this.changedTask+"&id="+this.idTask+"&date="+a+"&type="+t;try{fetch("tasks",{method:"PUT",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:s}).then((t=>t.json())).then((t=>{if(e.showLoadingSpinner=!1,null!=t?.errors)return alert(t.errors?.task),!1;this.$parent.$el.parentNode.removeChild(this.$parent.$el)}))}catch(n){console.log(n),e.showLoadingSpinner=!1}},deleteTask(){var t=this.$parent.$parent;t.showLoadingSpinner=!0;var e="id="+this.idTask;try{fetch("/tasks",{method:"DELETE",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:e}).then((t=>t.json())).then((e=>{if(t.showLoadingSpinner=!1,null!=e?.errors)return alert(e.errors?.task),!1;this.$parent.$el.removeChild(this.$parent.$el.children[0])}))}catch(a){console.log(a),t.showLoadingSpinner=!1}}}},b=T,v=(0,u.Z)(b,g,f,!1,null,null,null),w=v.exports,y=function(){var t=this,e=t._self._c;return e("div",{staticClass:"modal-mask",attrs:{tabindex:"-1"}},[e("div",{staticClass:"modal-wrapper text-white"},[e("div",[t._m(0),e("div",{staticClass:"modal-body bg-dark-theme"},[e("div",{staticClass:"mb-2"},[e("label",[t._v("Текст:")]),e("textarea",{staticClass:"form-control",attrs:{rows:"3"},domProps:{value:t.task},on:{input:t.changeTaskText}})])]),e("div",{staticClass:"modal-footer bg-dark-theme"},[e("button",{staticClass:"btn btn-secondary",attrs:{type:"button"},on:{click:t.hideModal}},[t._v("Закрыть")]),e("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:t.changeTask}},[t._v("Сохранить")])])])])])},C=[function(){var t=this,e=t._self._c;return e("div",{staticClass:"modal-header bg-dark-theme"},[e("h5",{staticClass:"modal-title"},[t._v("Редактирование")])])}],S={name:"TaskEditModal",props:["task","id","type"],mixins:[l],data(){return{token:document.querySelector("meta[name=csrf-token").getAttribute("content"),changedTask:this.task}},methods:{changeTaskText(t){this.changedTask=t.target.value},hideModal(){this.$parent.visibleModalChange=!1},changeTask(){let t=this.getDateTime(),e="task="+this.changedTask+"&id="+this.id+"&date="+t+"&type="+this.type;try{fetch("/tasks",{method:"PUT",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:e}).then((t=>t.json())).then((t=>{if(null!=t?.errors)return alert(t.errors?.task),!1;location.reload()}))}catch(a){console.log(a)}}}},x=S,_=(0,u.Z)(x,y,C,!1,null,"59dc825a",null),L=_.exports,I={name:"TaskItem",components:{TaskActionButton:w,TaskEditModal:L},props:["task","type","date","id"],data(){return{visibleTask:!0,visibleModalChange:!1,currentRoute:window.location.pathname,token:document.querySelector("meta[name=csrf-token").getAttribute("content")}},methods:{autoHeight(){document.getElementById("task_"+this.id).style.height=document.getElementById("task_"+this.id).scrollHeight+"px"}},mounted(){this.autoHeight()}},$=I,O=(0,u.Z)($,p,m,!1,null,null,null),A=O.exports,B=function(){var t=this;t._self._c;return t._m(0)},E=[function(){var t=this,e=t._self._c;return e("div",{staticClass:"modal-mask",attrs:{tabindex:"-1"}},[e("div",{staticClass:"modal-wrapper text-white"},[e("div",{staticClass:"spinner-border text-warning",attrs:{role:"status"}},[e("span",{staticClass:"sr-only"},[t._v("Loading...")])])])])}],F={name:"LoadingSpinner"},R=F,j=(0,u.Z)(R,B,E,!1,null,"7e792fc7",null),M=j.exports;const H={"/":0,"/home":0,"/done":1,"/archive":2,"/bookmarks":3};var N={name:"App",components:{TaskInput:k,TaskItem:A,LoadingSpinner:M},data(){return{tasks:[],currentRoute:window.location.pathname,showLoadingSpinner:!1,showInput:!0}},methods:{loadTasks(t){let e="/tasks?type="+t;var a=this;a.showLoadingSpinner=!0;try{fetch(e).then((t=>t.json())).then((e=>{a.showLoadingSpinner=!1;for(let a=0;a<e.length;a++){let s={};s.id=e[a].id,s.date=e[a].dt_task,s.task=e[a].task,s.type=t,this.tasks.push(s)}}))}catch(s){a.showLoadingSpinner=!1,console.log(s)}},getTasksFromLocalStorage(){let t=localStorage.getItem("tasks");if(null==t)t=[];else try{t=JSON.parse(t)}catch(e){t=[]}return t}},mounted(){if("/demo"==this.currentRoute){let t=this.getTasksFromLocalStorage();this.tasks=t}else this.loadTasks(H[this.currentRoute]);this.showInput="/done"!=this.currentRoute&&"/archive"!=this.currentRoute},flag_rewrite:!1},P=N,D=(0,u.Z)(P,n,i,!1,null,null,null),q=D.exports;s.ZP.config.productionTip=!1,new s.ZP({render:t=>t(q)}).$mount("#app")}},e={};function a(s){var n=e[s];if(void 0!==n)return n.exports;var i=e[s]={exports:{}};return t[s](i,i.exports,a),i.exports}a.m=t,function(){var t=[];a.O=function(e,s,n,i){if(!s){var o=1/0;for(d=0;d<t.length;d++){s=t[d][0],n=t[d][1],i=t[d][2];for(var r=!0,l=0;l<s.length;l++)(!1&i||o>=i)&&Object.keys(a.O).every((function(t){return a.O[t](s[l])}))?s.splice(l--,1):(r=!1,i<o&&(o=i));if(r){t.splice(d--,1);var c=n();void 0!==c&&(e=c)}}return e}i=i||0;for(var d=t.length;d>0&&t[d-1][2]>i;d--)t[d]=t[d-1];t[d]=[s,n,i]}}(),function(){a.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return a.d(e,{a:e}),e}}(),function(){a.d=function(t,e){for(var s in e)a.o(e,s)&&!a.o(t,s)&&Object.defineProperty(t,s,{enumerable:!0,get:e[s]})}}(),function(){a.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"===typeof window)return window}}()}(),function(){a.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)}}(),function(){var t={143:0};a.O.j=function(e){return 0===t[e]};var e=function(e,s){var n,i,o=s[0],r=s[1],l=s[2],c=0;if(o.some((function(e){return 0!==t[e]}))){for(n in r)a.o(r,n)&&(a.m[n]=r[n]);if(l)var d=l(a)}for(e&&e(s);c<o.length;c++)i=o[c],a.o(t,i)&&t[i]&&t[i][0](),t[i]=0;return a.O(d)},s=self["webpackChunkvue_front"]=self["webpackChunkvue_front"]||[];s.forEach(e.bind(null,0)),s.push=e.bind(null,s.push.bind(s))}();var s=a.O(void 0,[998],(function(){return a(6718)}));s=a.O(s)})();
//# sourceMappingURL=app.js.map