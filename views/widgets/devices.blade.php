<div class="panel">
    <div class="panel-heading">
        <h3>{{ xe_trans($title) }}</h3>
    </div>
    <div class="panel-body">
        <div id="__xe_visit-device-chart" style="width: 100%; height: 250px" data-progress-type="cover" data-progress-bgcolor="#ffffff"></div>
    </div>
</div>

<script>
//  @FIXME
window.jQuery(function ($) {
    window.google.charts.setOnLoadCallback(function () {
        dataLoad();
    });

    var dataLoad = function () {
        XE.ajax({
            url: '{{ route('ga::api.device') }}',
            type: 'get',
            data: {startdate: '{{ $startdate }}'},
            dataType: 'json',
            context: '#__xe_visit-device-chart',
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
            rows[i] = [rows[i][0], parseInt(rows[i][1])];
        }

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Device');
        data.addColumn('number', 'Visit');
        data.addRows(rows);

        var chart = new google.visualization.PieChart(document.getElementById('__xe_visit-device-chart'));

        chart.draw(data, {
            is3D: true,
            chartArea: {left:0, top:0, width:'100%',height:'100%'}
        });
    };
});
</script>
