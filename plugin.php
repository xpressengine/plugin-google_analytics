<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Route;
use Validator;
use View;
use XeFrontend;
use XeRegister;
use Xpressengine\Plugin\AbstractPlugin;
use Xpressengine\Translation\Translator;

class Plugin extends AbstractPlugin
{
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

    public function getSettingsURI()
    {
        return route('ga::setting.edit');
    }

    private function routes()
    {
        Route::group(['namespace' => 'Xpressengine\\Plugins\\GoogleAnalytics\\Controllers', 'as' => 'ga::'], function () {
            require plugins_path('google_analytics/routes.php');
        });
    }

    private function intercepts()
    {
        intercept('Presenter@make', 'googleAnalytics.addScript', function($target, $id, $data = [], $mergeData = [], $html = true, $api = false) {
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
        });
    }

    private function getTrackingCode($trackingId, $domain = 'auto')
    {
        return view('ga::tracking', compact('trackingId', 'domain'));
    }

    public function uninstall()
    {
        app('xe.ga')->getSetting()->destroy();
    }
}
