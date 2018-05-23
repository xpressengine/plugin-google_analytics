{{ XeFrontend::css('plugins/google_analytics/assets/skin.css')->load() }}
{{ XeFrontend::translation(['validation.mimes']) }}

@section('page_title')
    <h2>Google Analytics</h2>
@endsection

@section('page_description')
    setting for tracking & widget
@endsection

<div class="panel">
    <div class="panel-body">
        <form method="post" action="{{ route('ga::setting.update') }}" enctype="multipart/form-data" data-rule="analyticsSetting">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ xe_trans('ga::tracking') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ xe_trans('ga::trackingId') }}</label>
                                <input type="text" class="form-control" name="trackingId" value="{{ $setting->get('trackingId') ?: Request::old('trackingId') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ xe_trans('ga::trackingDomain') }} ({{ xe_trans('ga::optional') }})</label>
                                <input type="text" class="form-control" name="domain" value="{{ $setting->get('domain') ?: Request::old('domain') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ xe_trans('xe::widget') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ xe_trans('ga::profileId') }}</label>
                                <input type="text" class="form-control" name="profileId" value="{{ $setting->get('profileId') ?: Request::old('profileId') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="position: relative;">
                                <label>{{ xe_trans('ga::keyFile') }} (.json)</label>
                                <div class="{{ $setting->getKeyFile() ? 'collapse' : '' }}" id="__xe_file_input">
                                    <input type="file" class="form-control" name="keyFile">
                                </div>
                                @if($setting->getKeyFile())
                                    <div class="collapse in info-collapse" id="__xe_file_info">
                                        <input type="text" class="form-control" readonly value="{{ $setting->getKeyFile()->clientname }}">
                                        <span id="__xe_btn_remove_key_file" class="close">
                                            <i class="xi-close-min"></i>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ xe_trans('xe::save') }}</button>
        </form>
    </div>
</div>

<script>
//  @FIXME
window.jQuery(function ($) {
    $('#__xe_btn_remove_key_file').click(function (e) {
        e.preventDefault();

        $('#__xe_file_info').collapse('hide');
        $('#__xe_file_input').collapse('show');
    });

    window.XE.Validator.put('ga_json', function ($dst, parameters) {
        var value = $dst.val();

        if (value && 'json' !== value.split('.').pop()) {
            XE.Validator.error($dst, XE.Lang.trans('validation.mimes', {attribute: $dst.attr('name'), values: 'json'}));

            return false;
        }

        return true;
    });
});
</script>
