<div class="panel">
    <div class="panel-heading">
        <h3>{{ xe_trans($title) }}</h3>
    </div>
    <div class="panel-body">
        <div id="__xe_daily-visits-chart" style="width: 100%; height: 250px" data-progress-type="cover" data-progress-bgcolor="#ffffff"></div>
    </div>
</div>

<script>
window.jQuery(function ($) {
    google.charts.setOnLoadCallback(function () {
        dataLoad();
    });

    var dataLoad = function () {
        XE.ajax({
            url: '{{ route('ga::api.visit') }}',
            type: 'get',
            data: {startdate: '{{ $startdate }}', unit: '{{ $unit }}'},
            dataType: 'json',
            context: '#__xe_daily-visits-chart',
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
            var parsed = parseDate(rows[i][0]);
            rows[i] = [new Date(parsed[0], parseInt(parsed[1]) -1, parsed[2]), parseInt(rows[i][1])];
        }

        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Visit');
        data.addRows(rows);

        var chart = new google.visualization.LineChart(document.getElementById('__xe_daily-visits-chart'));

        chart.draw(data, {
//            title: 'Daily Visits',
            pointSize: 5,
            hAxis: {format: 'MM/dd'},
            vAxis: {format: 'short'},
            legend: 'none',
//            legend: { position: 'bottom' }
            chartArea: {left:30, top:20, width:'90%',height:'80%'}
        });
    };

    var parseDate = function (strDate) {
        var y = strDate.substr(0, 4),
            m = strDate.substr(4, 2),
            d = strDate.substr(6, 2);

        return [y, m, d];
    };
});
</script>
