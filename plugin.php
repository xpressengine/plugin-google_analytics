<?php
/**
 * Plugin.php
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

namespace Xpressengine\Plugins\GoogleAnalytics;

use Route;
use Validator;
use View;
use XeFrontend;
use XeRegister;
use Xpressengine\Plugin\AbstractPlugin;
use Xpressengine\Translation\Translator;

/**
 * Plugin
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */
class Plugin extends AbstractPlugin
{
    /**
     * boot
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('ga_json', function ($attribute, $value) {
            return 'json' === $value->getClientOriginalExtension();
        });
        Validator::replacer('ga_json', function ($message, $attribute, $rule, $parameters) {
            return xe_trans('validation.mimes', ['attribute' => $attribute, 'values' => 'json']);
        });

        View::addNamespace('ga', __DIR__ . '/views');
        Translator::alias('google_analytics', 'ga');
    }

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(Handler::class, function ($app) {
            return new Handler(
                $app,
                new Setting($app['xe.config'], $app['xe.storage'], $app['xe.keygen'])
            );
        }, true);
        app()->alias(Handler::class, 'xe.ga');

        $this->routes();
        $this->intercepts();
    }

    /**
     * get setting uri
     *
     * @return string
     */
    public function getSettingsURI()
    {
        return route('ga::setting.edit');
    }

    /**
     * add route
     *
     * @return void
     */
    private function routes()
    {
        Route::group(
            ['namespace' => 'Xpressengine\\Plugins\\GoogleAnalytics\\Controllers', 'as' => 'ga::'],
            function () {
                require plugins_path('google_analytics/routes.php');
            }
        );
    }

    /**
     * register intercept
     *
     * @return void
     */
    private function intercepts()
    {
        intercept(
            'Presenter@make',
            'googleAnalytics.addScript',
            function ($target, $id, $data = [], $mergeData = [], $html = true, $api = false) {
                /** @var \Illuminate\Routing\Route $route */
                $route = app('router')->current();
                if ($route && in_array('settings', $route->middleware()) === false) {
                    $setting = app('xe.ga')->getSetting();
                    if ($setting->get('trackingId')) {
                        XeFrontend::html('ga:tracking')->content(
                            $this->getTrackingCode($setting->get('trackingId'), $setting->get('domain', 'auto'))
                        )->load();
                    }
                }

                return $target($id, $data, $mergeData, $html, $api);
            }
        );
    }

    /**
     * get tracking code
     *
     * @param string $trackingId tracking id
     * @param string $domain     domain
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getTrackingCode($trackingId, $domain = 'auto')
    {
        return view('ga::tracking', compact('trackingId', 'domain'));
    }

    /**
     * uninstall
     *
     * @return void
     */
    public function uninstall()
    {
        app('xe.ga')->getSetting()->destroy();
    }
}
