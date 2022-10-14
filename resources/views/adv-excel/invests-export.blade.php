<?php 
    $setYear = date('Y');
    if(isset($_REQUEST['setYear']))
    {
        $setYear = $_REQUEST['setYear'];
    }
?>
<div class="card">
    <div class="card-header">
        <h4>{{$setYear}}年-{{ $title }}</h4>
    </div>
    
    <div class="card-body">
        <form method="get" >
            <input type="text" id="datepicker" name="setYear" value=<?php echo $setYear?> />
            <button class="btn btn-info submit btn-sm"><i class="fa fa-search"></i>&nbsp;&nbsp;搜索</button>
        </form>
        <a href="" target="_blank" id="advexcel" class="btn btn-sm btn-info" ><i class="fa fa-download"></i>彙總匯出</a>
    </div>
    <div class="card-body">
        <canvas id="visitors-chart"></canvas>
    </div>
    <div class="card-body">
        <canvas id="myChart"></canvas>
    </div>
    
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>


<script>
    $("#datepicker").datepicker( {
        format: " yyyy",
        viewMode: "years", 
        minViewMode: "years",
        setDate: new Date().getFullYear(),
    });

    var target = "/excel/addition-invest";
    $("#advexcel").click(function(){
        var setYear = $("#datepicker").val();
        var date_time_start = setYear+'-01-01';
        var date_time_end = setYear+'-12-31';

        window.location.href = "/excel/addition-invest?start_time="+date_time_start+"&end_time="+date_time_end+"";
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('myChart');
    var chartEl = document.getElementById("visitors-chart");
    ctx.height = 400;
    chartEl.height = 400;
    <?php echo $jscode?>
</script>