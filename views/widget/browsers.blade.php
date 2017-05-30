<div class="box box-error">
    <div class="box-header with-border">
        <h3 class="box-title">{{ xe_trans('ga::browser') }}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body" style="display: block;">

        <div id="__xe_browsers-chart" style="width: 100%; height: 250px"></div>

    </div><!-- /.box-body -->
</div>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(function () {
        var rows = eval('({!! $jsonData !!})');
        for (var i = 0; i < rows.length; i++) {
            rows[i] = [rows[i][0], parseInt(rows[i][1])];
        }

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Browser');
        data.addColumn('number', 'Visit');
        data.addRows(rows);

        var chart = new google.visualization.PieChart(document.getElementById('__xe_browsers-chart'));

        chart.draw(data, {
            is3D: true,
            chartArea: {left:0, top:0, width:'100%',height:'100%'}
        });
    });
</script>
