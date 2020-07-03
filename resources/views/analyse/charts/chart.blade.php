<style>
    .highcharts-container {
        min-width: 100% !important;
    }
</style>
<div id="app">
    {!! $chart->container() !!}
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
{!! $chart->script() !!}