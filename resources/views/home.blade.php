@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="app">
                <task-list :tasks="tasks"></task-list>
            </div>

        </div>
    </div>
</div>

        

@endsection