@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-8">
            <div class="card-body">
                <div id="app">
                    <task-list :tasks="tasks"></task-list>
                </div>
            </div>
        </div>
        
    </div>
    <div class="card">
            <a href={{ route('send') }}>Отпрвить</a>
        </div>
</div>

        

@endsection