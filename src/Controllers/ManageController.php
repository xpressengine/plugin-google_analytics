<?php
/**
 * ManageController.php
 *
 * This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XeFrontend;
use XePresenter;
use XeStorage;
use XeDB;
use Xpressengine\Plugins\GoogleAnalytics\Handler;

/**
 * ManageController
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */
class ManageController extends Controller
{
    /**
     * ManageController constructor.
     */
    public function __construct()
    {
        XePresenter::setSkinTargetId('google_analytics');
    }

    /**
     * get setting
     *
     * @param Handler $handler handler
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     */
    public function getSetting(Handler $handler)
    {
        $ruleName = 'analyticsSetting';
        XeFrontend::rule($ruleName, $this->getRules());

        return XePresenter::make('settings.setting', [
            'setting' => $handler->getSetting(),
            'ruleName' => $ruleName
        ]);
    }

    /**
     * post setting
     *
     * @param Request $request request
     * @param Handler $handler handler
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * get rules
     *
     * @return array
     */
    private function getRules()
    {
        return [
            'profileId' => 'numeric',
            'keyFile' => 'ga_json',
            'trackingId' => 'required'
        ];
    }
}
