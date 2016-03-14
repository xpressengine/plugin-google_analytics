<?php
namespace Xpressengine\Plugins\GoogleAnalytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XePresenter;
use Keygen;
use Storage;

class ManageController extends Controller
{
    public function __construct()
    {
        XePresenter::setModule('google_analytics');
    }

    public function getSetting()
    {
        $ruleName = 'analyticsSetting';
        \XeFrontend::rule($ruleName, $this->getRules());

        return XePresenter::make('setting', [
            'setting' => app('xe.plugin.ga')->getSetting(),
            'ruleName' => $ruleName
        ]);
    }

    public function postSetting(Request $request)
    {
        $setting = app('xe.plugin.ga')->getSetting();

        $rules = $this->getRules();

        if ($setting->getKeyFile() === null) {
            $rules = array_merge($rules, ['keyFile' => 'Required']);
        }

        $this->validate($request, $rules);

        $inputs = $request->only([
            'projectName',
            'accountEmail',
            'clientId',
            'profileId',
            'trackingId',
            'domain',
        ]);
        $setting->set($inputs);

        if ($request->file('keyFile') !== null) {
            $file = Storage::upload($request->file('keyFile'), 'google/analytics');
            $setting->setKeyFile($file);
        }

        return redirect()->route('manage.google_analytics.edit');
    }

    private function getRules()
    {
        return [
            'projectName' => 'Required',
            'accountEmail' => 'Required|Email',
            'clientId' => 'Required',
            'profileId' => 'Required|Numeric',
            'trackingId' => 'Required'
        ];
    }
}
