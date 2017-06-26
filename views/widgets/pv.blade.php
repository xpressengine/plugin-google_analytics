<div class="panel">
    <div class="panel-heading">
        <h3>{{ xe_trans($title) }}</h3>
    </div>
    <div class="panel-body">
        <table class="table" id="__xe_page-views-table">
            <thead>
            <tr>
                <th>Page</th>
                <th>Count</th>
                <th>Percent</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var dataLoad = function () {
            $.ajax({
                url: '{{ route('plugin.ga.api.pv') }}',
                type: 'get',
                data: {startdate: '{{ $startdate }}', limit: '{{ $limit }}'},
                dataType: 'json',
                success: function (response) {
                    draw(response);
                },
                error: function () {

                }
            });
        };

        var draw = function (rawData) {
            var rows = rawData, tpl, src, cnt, per, total = 0;
            for (var i = 0; i < rows.length; i++) {
                total += parseInt(rows[i][1]);
            }

            for (var i = 0; i < rows.length; i++) {
//                rows[i] = [rows[i][0], parseInt(rows[i][1])];
                src = rows[i][0];
                cnt = parseInt(rows[i][1]);
                per = parseInt(cnt / total * 100) + Math.round(((cnt / total * 100) - parseInt(cnt / total * 100)) * 100) / 100 + '%';

                tpl = '<tr>'
                    + ' <td>' + src + '</td>'
                    + ' <td>' + cnt + '</td>'
                    + ' <td>'
                    + '     <div class="progress" style="background-color: #c4c4c4;">'
                    + '         <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:'+ per +'">'
                    +               per
                    + '         </div>'
                    + '     </div>'
                    + ' </td>'
                    + '</tr>';

                $('#__xe_page-views-table tbody').append(tpl);
            }
        };

        dataLoad();
    });
</script>