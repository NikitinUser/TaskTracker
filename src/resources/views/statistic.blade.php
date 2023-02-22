@extends('layouts.app')
@section('content')

<div class="container bg-dark-theme">
    <div class="row justify-content-center bg-dark-theme">
        <div class="col-md-10 bg-dark-theme">
            <div class="card-body bg-dark-tasks-theme">
                <canvas class="bg-dark-tasks-theme" id="myChart" width="400" height="250"></canvas>
            </div>
        </div>
        
    </div>
</div>

<script src="{{ asset('js/statistic.js') }}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.1/chart.min.js"></script>

@endsection
