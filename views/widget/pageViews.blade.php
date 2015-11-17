<div class="box box-error">
    <div class="box-header with-border">
        <h3 class="box-title">{{ xe_trans('ga:pageViews') }}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body" style="display: block;">

        <table class="table">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Count</th>
                    <th>Percent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $val)
                <tr>
                    <td>{{ $val[0] }}</td>
                    <td>{{ $val[1] }}</td>
                    <td>
                        <div class="progress" style="background-color: #c4c4c4;">
                            <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ sprintf('%.2f', $val[1] / $total * 100) . '%' }}">
                                {{ sprintf('%.2f', $val[1] / $total * 100) . '%' }}
                            </div>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div><!-- /.box-body -->
</div>