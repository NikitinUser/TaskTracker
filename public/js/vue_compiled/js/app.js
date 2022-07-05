(function(){"use strict";var t={8298:function(t,e,s){var a=s(6369),i=function(){var t=this,e=t._self._c;return e("div",{staticClass:"row justify-content-center bg-dark-theme",attrs:{id:"app"}},[e("div",{staticClass:"col-md-7 bg-dark-theme"},[t.showInput?e("TaskInput"):t._e(),e("ul",{staticClass:"list-group list-group-flush",attrs:{id:"task-list"}},t._l(t.tasks,(function(t){return e("li",{key:t.id,staticClass:"list-group-item list-group-item-darktheme border border-dark"},[e("TaskItem",{attrs:{task:t.task,priority:t.priority,type:t.type,date:t.date,id:t.id,theme:t.theme}})],1)})),0),e("LoadingSpinner",{directives:[{name:"show",rawName:"v-show",value:t.showLoadingSpinner,expression:"showLoadingSpinner"}]}),e("datalist",{attrs:{id:"suggestions-themes"}},t._l(t.suggestionsThemes,(function(s){return e("option",{key:s.theme},[t._v(" "+t._s(s.theme??"Без темы")+" ")])})),0)],1)])},n=[],o=function(){var t=this,e=t._self._c;return e("div",{staticClass:"input-group mb-3 bg-dark-theme",attrs:{id:"task-input"}},[e("input",{staticClass:"form-control bg-dark-theme",attrs:{type:"text",name:"newTask",id:"newTask",placeholder:"Задача",size:"100"},domProps:{value:t.task},on:{input:t.inputTask}}),e("span",{staticClass:"input-group-append"},[e("select",{staticClass:"form-select",attrs:{name:"priorityTask",id:"priorityTask"},domProps:{value:t.priority},on:{change:t.selectPriority}},[e("option",{attrs:{value:"0"}},[t._v("Low")]),e("option",{attrs:{value:"1"}},[t._v("Middle")]),e("option",{attrs:{value:"2"}},[t._v("High")])])]),e("span",{staticClass:"input-group-append"},[e("button",{staticClass:"btn btn-secondary",attrs:{id:"add_task_btn",type:"button"},on:{click:function(e){return t.addTask()}}},[e("i",{staticClass:"fa fa-plus"})])])])},r=[],l={methods:{getDateTime(){let t=new Date,e=String(t.getDate()).padStart(2,"0"),s=String(t.getMonth()+1).padStart(2,"0"),a=t.getFullYear(),i=t.getHours(),n=t.getMinutes(),o=t.getSeconds();return e+"-"+s+"-"+a+" "+i+":"+n+":"+o}}},c={name:"TaskInput",mixins:[l],data(){return{task:"",priority:0,date:"",token:document.querySelector("meta[name=csrf-token").getAttribute("content")}},methods:{inputTask(t){this.task=t.target.value},selectPriority(t){this.priority=t.target.value},addTask(){if(this.date=this.getDateTime(),"/demo"==this.$parent.currentRoute)this.saveTaskToLocalStorage();else{let t=0;"/bookmarks"==this.$parent.currentRoute&&(t=3);let e="task="+this.task+"&date="+this.date+"&priority="+this.priority+"&type="+t;this.saveTaskOnServer(e)}this.cleanInput()},saveTaskToLocalStorage(){let t=this.$parent.getTasksFromLocalStorage(),e={id:t.length+1+this.date,task:this.task,priority:this.priority,date:this.date};t.push(e),this.$parent.tasks=t,t=JSON.stringify(t),localStorage.setItem("tasks",t)},saveTaskOnServer(t){var e=this.$parent;e.showLoadingSpinner=!0;try{fetch("addTask",{method:"POST",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:t}).then((t=>t.json())).then((t=>{if(e.showLoadingSpinner=!1,null!=t?.errors)return alert(t.errors?.task),!1;if(null==t.id)alert("Количество задач в этом списке стало равным 50. Это количество нельзя превышать, займись делом.");else{let e={};e.id=t.id,e.date=t.date,e.task=t.task,e.priority=t.priorityTask,e.type=t.type,this.$parent.tasks.push(e)}}))}catch(s){console.log(s),e.showLoadingSpinner=!1}},cleanInput(){this.task="",this.priority=0,this.date=""}}},d=c,h=s(1001),u=(0,h.Z)(d,o,r,!1,null,null,null),p=u.exports,k=function(){var t=this,e=t._self._c;return e("div",{staticStyle:{"min-height":"200px"},attrs:{id:t.id}},[e("div",[e("div",{staticClass:"d-flex flex-row mb-3",staticStyle:{"min-height":"150px"}},[e("div",{staticClass:"text-white d-flex flex-column",staticStyle:{"max-width":"20%"}},[e("div",{staticClass:"mb-3"},[e("label",{attrs:{id:t.id}},[t._v(" "+t._s(t.theme??"Без темы")+" ")])]),e("div",{staticClass:"mb-3 d-flex flex-column"},[e("em",{staticStyle:{"font-size":"small"}},[t._v(" "+t._s(t.date.split(" ")[0])+" ")]),e("em",{staticStyle:{"font-size":"small"}},[t._v(" "+t._s(t.date.split(" ")[1])+" ")])]),e("div",[e("button",{staticClass:"btn btn-outline-light btn-sm",attrs:{type:"button"},on:{click:function(e){t.visibleTask=!t.visibleTask}}},[t._v(" "+t._s(t.visibleTask?"Скрыть":"Показать")+" ")])])]),e("div",{staticClass:"text-white d-flex justify-content-center w-100 ms-3 me-1"},[e("span",{directives:[{name:"show",rawName:"v-show",value:t.visibleTask,expression:"visibleTask"}],attrs:{id:t.id}},[t._v(" "+t._s(t.task)+" "),0==t.priority?e("i",{staticClass:"ms-1"}):1==t.priority?e("i",{staticClass:"ms-1 fa fa-exclamation-circle text-warning"}):2==t.priority?e("i",{staticClass:"ms-1 fa fa-exclamation-circle text-danger"}):t._e()]),e("input",{attrs:{id:t.id,type:"hidden"},domProps:{value:t.priority}})])]),"/demo"==t.currentRoute?e("div",{staticClass:"text-white d-flex flex-row pull-right"},[e("TaskActionButton",{attrs:{buttonIcon:"fa fa-check-square",buttonClass:"pull-right btn btn-outline-success w-100",action:"removeTaskFromLocal",idTask:t.id}})],1):e("div",{staticClass:"text-white d-flex flex-row pull-right"},["/done"!=t.currentRoute?e("TaskActionButton",{attrs:{buttonIcon:"fa fa-check-square",buttonClass:"pull-right btn btn-outline-success w-100",action:"swapTaskToDone",idTask:t.id}}):e("TaskActionButton",{attrs:{buttonIcon:"fa fa-trash",buttonClass:"pull-right btn btn-outline-danger w-100",action:"deleteTask",idTask:t.id}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-location-arrow",buttonClass:"pull-right btn btn-outline-success w-100",action:"swapTaskToTasks",idTask:t.id}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-bookmark",buttonClass:"pull-right btn btn-outline-primary w-100",action:"swapTaskToBookmarks",idTask:t.id}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-archive",buttonClass:"pull-right btn btn-outline-info w-100",action:"swapTaskToArchive",idTask:t.id}}),e("TaskActionButton",{attrs:{buttonIcon:"fa fa-pencil-square",buttonClass:"pull-right btn btn-outline-warning w-100",action:"editTask",idTask:t.id}})],1)]),e("div",{staticClass:"justify-content-center pt-5",staticStyle:{display:"none"},attrs:{id:"recoveryTask"}},[e("button",{staticClass:"btn btn-outline-primary",attrs:{type:"button"},on:{click:t.recoverTask}},[t._v(" Восстановить ")])]),e("TaskEditModal",{directives:[{name:"show",rawName:"v-show",value:t.visibleModalChange,expression:"visibleModalChange"}],attrs:{id:t.id,priority:t.priority,task:t.task,theme:t.theme}})],1)},m=[],g=function(){var t=this,e=t._self._c;return e("div",{staticClass:"me-2"},[e("button",{class:t.buttonClass,attrs:{id:t.idTask},on:{click:t.taskBtnAction}},[e("i",{class:t.buttonIcon})])])},v=[],T={name:"TaskActionButton",props:["buttonClass","buttonIcon","action","idTask"],mixins:[l],data(){return{token:document.querySelector("meta[name=csrf-token").getAttribute("content")}},methods:{taskBtnAction(){"removeTaskFromLocal"==this.action?this.removeTaskFromLocal():"swapTaskToDone"==this.action?this.taskSwapType(1):"deleteTask"==this.action?this.deleteTask():"swapTaskToTasks"==this.action?this.taskSwapType(0):"swapTaskToBookmarks"==this.action?this.taskSwapType(3):"swapTaskToArchive"==this.action?this.taskSwapType(2):"editTask"==this.action&&(this.$parent.visibleModalChange=!0)},removeTaskFromLocal(){let t=this.$parent.$parent.getTasksFromLocalStorage(),e=[];for(let s=0;s<t.length;s++)t[s].id!=this.idTask&&e.push(t[s]);this.$parent.$parent.tasks=e,t=JSON.stringify(e),localStorage.setItem("tasks",t)},taskSwapType(t){var e=this.$parent.$parent;e.showLoadingSpinner=!0;let s=this.getDateTime(),a="id="+this.idTask+"&date="+s+"&type="+t;try{fetch("taskSwapType",{method:"POST",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:a}).then((t=>t.json())).then((t=>{if(e.showLoadingSpinner=!1,null!=t?.errors)return alert(t.errors?.task),!1;this.$parent.$el.parentNode.removeChild(this.$parent.$el)}))}catch(i){console.log(i),e.showLoadingSpinner=!1}},deleteTask(){var t=this.$parent.$parent;t.showLoadingSpinner=!0;var e="id="+this.idTask;try{fetch("deleteTask",{method:"POST",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:e}).then((t=>t.json())).then((e=>{if(t.showLoadingSpinner=!1,null!=e?.errors)return alert(e.errors?.task),!1;this.$parent.$el.removeChild(this.$parent.$el.children[0]),this.$parent.$el.children[0].style.display="flex"}))}catch(s){console.log(s),t.showLoadingSpinner=!1}}}},f=T,b=(0,h.Z)(f,g,v,!1,null,null,null),y=b.exports,w=function(){var t=this,e=t._self._c;return e("div",{staticClass:"modal-mask",attrs:{tabindex:"-1"}},[e("div",{staticClass:"modal-wrapper text-white"},[e("div",[t._m(0),e("div",{staticClass:"modal-body bg-dark-theme"},[e("div",{staticClass:"mb-2"},[e("label",[t._v("Текст:")]),e("textarea",{staticClass:"form-control",attrs:{rows:"3"},domProps:{value:t.task},on:{input:t.changeTaskText}})]),e("div",{staticClass:"mb-2"},[e("label",[t._v("Приоритетность:")]),e("select",{staticClass:"form-select",domProps:{value:t.priority},on:{change:t.changePriority}},[e("option",{attrs:{value:"0"}},[t._v(" Low ")]),e("option",{attrs:{value:"1"}},[t._v(" Middle")]),e("option",{attrs:{value:"2"}},[t._v(" High")])])]),e("div",{staticClass:"mb-2"},[e("label",[t._v("Тема задачи:")]),e("input",{staticClass:"form-control",attrs:{type:"text",name:"theme",list:"suggestions-themes"},domProps:{value:t.theme},on:{input:t.changeTheme}})])]),e("div",{staticClass:"modal-footer bg-dark-theme"},[e("button",{staticClass:"btn btn-secondary",attrs:{type:"button"},on:{click:t.hideModal}},[t._v("Закрыть")]),e("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:t.changeTask}},[t._v("Сохранить")])])])])])},C=[function(){var t=this,e=t._self._c;return e("div",{staticClass:"modal-header bg-dark-theme"},[e("h5",{staticClass:"modal-title"},[t._v("Редактирование")])])}],S={name:"TaskEditModal",props:["task","priority","id","theme"],data(){return{token:document.querySelector("meta[name=csrf-token").getAttribute("content"),changedTask:this.task,changedPriority:this.priority,changedTheme:this.theme}},methods:{changeTaskText(t){this.changedTask=t.target.value},changePriority(t){this.changedPriority=t.target.value},changeTheme(){this.changedTheme=event.target.value},hideModal(){this.$parent.visibleModalChange=!1},changeTask(){let t="task="+this.changedTask+"&priority="+this.changedPriority+"&id="+this.id+"&theme="+this.changedTheme;try{fetch("changeTask",{method:"POST",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:t}).then((t=>t.json())).then((t=>{if(null!=t?.errors)return alert(t.errors?.task),!1;location.reload()}))}catch(e){console.log(e)}}}},_=S,x=(0,h.Z)(_,w,C,!1,null,"0e29a724",null),L=x.exports,$={name:"TaskItem",components:{TaskActionButton:y,TaskEditModal:L},props:["task","priority","type","date","id","theme"],data(){return{visibleTask:!0,visibleModalChange:!1,currentRoute:window.location.pathname,token:document.querySelector("meta[name=csrf-token").getAttribute("content")}},methods:{recoverTask(){let t="id="+this.id;try{fetch("recoverTask",{method:"POST",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded","X-CSRF-TOKEN":this.token}),body:t}).then((t=>t.json())).then((t=>{if(null!=t?.errors)return alert(t.errors?.task),!1;0!=t.length&&0!=t&&null!=t||alert("Эту запись нельзя восстановить"),location.reload()}))}catch(e){console.log(e)}}}},O=$,I=(0,h.Z)(O,k,m,!1,null,null,null),P=I.exports,A=function(){var t=this;t._self._c;return t._m(0)},j=[function(){var t=this,e=t._self._c;return e("div",{staticClass:"modal-mask",attrs:{tabindex:"-1"}},[e("div",{staticClass:"modal-wrapper text-white"},[e("div",{staticClass:"spinner-border text-warning",attrs:{role:"status"}},[e("span",{staticClass:"sr-only"},[t._v("Loading...")])])])])}],F={name:"LoadingSpinner"},M=F,R=(0,h.Z)(M,A,j,!1,null,"7e792fc7",null),B=R.exports;const N={"/":0,"/home":0,"/done":1,"/archive":2,"/bookmarks":3};var E={name:"App",components:{TaskInput:p,TaskItem:P,LoadingSpinner:B},data(){return{tasks:[],currentRoute:window.location.pathname,suggestionsThemes:[],showLoadingSpinner:!1,showInput:!0}},methods:{loadTasks(t){let e="/get_tasks?type="+t;var s=this;s.showLoadingSpinner=!0;try{fetch(e).then((t=>t.json())).then((e=>{s.showLoadingSpinner=!1;for(let s=0;s<e.length;s++){let a={};a.id=e[s].id,a.date=e[s].dt_task,a.task=e[s].task,a.priority=e[s].priority,a.type=t,a.theme=e[s].theme,this.tasks.push(a)}}))}catch(a){s.showLoadingSpinner=!1,console.log(a)}},getTasksThemes(){var t=this;fetch("get_tasks_themes",{method:"GET"}).then((t=>t.json())).then((e=>{t.suggestionsThemes=e}))},getTasksFromLocalStorage(){let t=localStorage.getItem("tasks");if(null==t)t=[];else try{t=JSON.parse(t)}catch(e){t=[]}return t}},mounted(){if("/demo"==this.currentRoute){let t=this.getTasksFromLocalStorage();this.tasks=t}else this.loadTasks(N[this.currentRoute]),this.getTasksThemes();this.showInput="/done"!=this.currentRoute&&"/archive"!=this.currentRoute},flag_rewrite:!1},H=E,Z=(0,h.Z)(H,i,n,!1,null,null,null),q=Z.exports;a.ZP.config.productionTip=!1,new a.ZP({render:t=>t(q)}).$mount("#app")}},e={};function s(a){var i=e[a];if(void 0!==i)return i.exports;var n=e[a]={exports:{}};return t[a](n,n.exports,s),n.exports}s.m=t,function(){var t=[];s.O=function(e,a,i,n){if(!a){var o=1/0;for(d=0;d<t.length;d++){a=t[d][0],i=t[d][1],n=t[d][2];for(var r=!0,l=0;l<a.length;l++)(!1&n||o>=n)&&Object.keys(s.O).every((function(t){return s.O[t](a[l])}))?a.splice(l--,1):(r=!1,n<o&&(o=n));if(r){t.splice(d--,1);var c=i();void 0!==c&&(e=c)}}return e}n=n||0;for(var d=t.length;d>0&&t[d-1][2]>n;d--)t[d]=t[d-1];t[d]=[a,i,n]}}(),function(){s.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return s.d(e,{a:e}),e}}(),function(){s.d=function(t,e){for(var a in e)s.o(e,a)&&!s.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:e[a]})}}(),function(){s.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"===typeof window)return window}}()}(),function(){s.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)}}(),function(){var t={143:0};s.O.j=function(e){return 0===t[e]};var e=function(e,a){var i,n,o=a[0],r=a[1],l=a[2],c=0;if(o.some((function(e){return 0!==t[e]}))){for(i in r)s.o(r,i)&&(s.m[i]=r[i]);if(l)var d=l(s)}for(e&&e(a);c<o.length;c++)n=o[c],s.o(t,n)&&t[n]&&t[n][0](),t[n]=0;return s.O(d)},a=self["webpackChunkvue_front"]=self["webpackChunkvue_front"]||[];a.forEach(e.bind(null,0)),a.push=e.bind(null,a.push.bind(a))}();var a=s.O(void 0,[998],(function(){return s(8298)}));a=s.O(a)})();
//# sourceMappingURL=app.js.map