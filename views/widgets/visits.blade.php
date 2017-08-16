<div class="panel">
    <div class="panel-heading">
        <h3>{{ xe_trans($title) }}</h3>
    </div>
    <div class="panel-body">
        <div id="__xe_daily-visits-chart" style="width: 100%; height: 250px"></div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        google.charts.setOnLoadCallback(function () {
            dataLoad();
        });

        var dataLoad = function () {
            $.ajax({
                url: '{{ route('ga::api.visit') }}',
                type: 'get',
                data: {startdate: '{{ $startdate }}', unit: '{{ $unit }}'},
                dataType: 'json',
                success: function (response) {
                    draw(response);
                },
                error: function () {

                }
            });
        };

        var draw = function (rawData) {
            var rows = rawData;
            for (var i = 0; i < rows.length; i++) {
                rows[i] = [new Date(rows[i][0]*1000), parseInt(rows[i][1])];
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
        };
    });
</script>
