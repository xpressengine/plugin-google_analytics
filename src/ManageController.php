<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XePresenter;
use XeStorage;
use XeDB;

class ManageController extends Controller
{
    public function __construct()
    {
        XePresenter::setSkinTargetId('google_analytics');
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

        $this->validate($request, $rules);

        $inputs = $request->only([
            'projectName',
            'accountEmail',
            'clientId',
            'profileId',
            'trackingId',
            'domain',
        ]);

        XeDB::beginTransaction();
        try {
            $setting->set($inputs);

            if ($request->file('keyFile') !== null) {
                $file = XeStorage::upload($request->file('keyFile'), 'google/analytics');
                $setting->setKeyFile($file);
            }
        } catch (\Exception $e) {
            XeDB::rollBack();
        }
        XeDB::commit();

        return redirect()->route('manage.google_analytics.edit');
    }

    private function getRules()
    {
        return [
            'accountEmail' => 'email',
            'profileId' => 'numeric',
            'keyFile' => 'p12',
            'trackingId' => 'required'
        ];
    }
}
