@extends('layouts.app')
@section('content')

@verbatim
    <div id="app"></div>

    <script defer="defer" src="/js/vue_compiled/js/chunk-vendors.js"></script>
    <script defer="defer" src="/js/vue_compiled/js/app.js"></script>

    <link href="/js/vue_compiled/css/app.css" rel="stylesheet">
@endverbatim 

@endsection
