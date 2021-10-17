<div class="app-body bg-dark h-100">
  <div class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav d-flex flex-column">

    	  <li class="nav-item">
        	<a class="nav-link text-white" href="/"><i class="icon-speedometer"></i> Главная</a>
      	</li>
          
        {{--@role('admin')--}}
            @include('layouts.users-management.sidebar')
            {{--@endrole--}}
      </ul>
    </nav>
  </div>
</div>