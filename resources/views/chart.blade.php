<div class="card">
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">
        <canvas id="visitors-chart"></canvas>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

<script>
    var chartEl = document.getElementById("visitors-chart");
    chartEl.height = 700;
    <?php echo $jscode?>
</script>

<style>
    #visitors-chart {
        height: 200px;
    }
</style>