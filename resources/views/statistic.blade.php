@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-10">
            <div class="card-body">
                <canvas id="myChart" width="400" height="250"></canvas>
            </div>
        </div>
        
    </div>
</div>

<script src="{{ asset('js/statistic.js') }}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.1/chart.min.js"></script>

@endsection
