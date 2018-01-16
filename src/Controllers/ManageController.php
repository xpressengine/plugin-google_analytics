<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XeFrontend;
use XePresenter;
use XeStorage;
use XeDB;
use Xpressengine\Plugins\GoogleAnalytics\Handler;

class ManageController extends Controller
{
    public function __construct()
    {
        XePresenter::setSkinTargetId('google_analytics');
    }

    public function getSetting(Handler $handler)
    {
        $ruleName = 'analyticsSetting';
        XeFrontend::rule($ruleName, $this->getRules());

        return XePresenter::make('settings.setting', [
            'setting' => $handler->getSetting(),
            'ruleName' => $ruleName
        ]);
    }

    public function postSetting(Request $request, Handler $handler)
    {
        $setting = $handler->getSetting();

        $rules = $this->getRules();

        if ($request->file('keyFile') == null) {
            unset($rules['keyFile']);
        }
        if ($request->file('profileId') == null) {
            unset($rules['profileId']);
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

        return redirect()->route('ga::setting.edit');
    }

    private function getRules()
    {
        return [
            'profileId' => 'numeric',
            'keyFile' => 'ga_json',
            'trackingId' => 'required'
        ];
    }
}
