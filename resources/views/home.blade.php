@extends('layouts.app')
@section('content')

<div id="app"></div>

<footer class="page-footer mt-2 mb-3"></footer>

<script defer="defer" src="/js/vue_compiled/js/chunk-vendors.js"></script>
<script defer="defer" src="/js/vue_compiled/js/app.js"></script>

<link href="/js/vue_compiled/css/app.css" rel="stylesheet">

<script type="text/javascript">
	document.addEventListener('keydown', function(event) {
	  if (event.keyCode === 13) {
	   	addTask();
	  }
	});

</script>	

@endsection
