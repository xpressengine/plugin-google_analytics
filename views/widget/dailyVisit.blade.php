<div class="box box-error">
    <div class="box-header with-border">
        <h3 class="box-title">{{ xe_trans('ga::dailyVisit') }}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body" style="display: block;">

        <div id="__xe_daily-visits-chart" style="width: 100%; height: 250px"></div>

    </div><!-- /.box-body -->
</div>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(function () {
        var rows = eval('({!! $jsonData !!})');
        for (var i = 0; i < rows.length; i++) {
            rows[i] = [new Date(rows[i][0]), rows[i][1]];
        }

        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Visit');
        data.addRows(rows);

        var chart = new google.visualization.LineChart(document.getElementById('__xe_daily-visits-chart'));

        chart.draw(data, {
//            title: 'Daily Visits',
            pointSize: 5,
            hAxis: {format: 'MMM dd'},
            vAxis: {format: 'short'},
            legend: 'none',
//            legend: { position: 'bottom' }
            chartArea: {left:30, top:20, width:'90%',height:'80%'}
        });
    });
</script>
