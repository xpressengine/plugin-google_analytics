<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Xpressengine\Plugin\AbstractPlugin;
use XeFrontend;
use Route;
use Validator;
use View;
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
        app()->bind('xe.plugin.ga', function () {
            return $this;
        }, true);

        app()->singleton('xe.plugin.ga.handler', function ($app) {
            return new Handler(
                $app,
                new Setting($app['xe.config'], $app['xe.storage'], $app['xe.keygen'])
            );
        }, true);

        $this->registerRoute();
        $this->registerEvent();
    }

    public function activate($installedVersion = null)
    {
        //
    }

    public function getSettingsURI()
    {
        return route('manage.google_analytics.edit');
    }

    private function registerRoute()
    {
        Route::settings($this->getId(), function () {
            Route::get('setting', [
                'as' => 'manage.google_analytics.edit',
                'uses' => 'ManageController@getSetting'
            ]);
            Route::post('setting', [
                'as' => 'manage.google_analytics.update',
                'uses' => 'ManageController@postSetting'
            ]);
        }, ['namespace' => __NAMESPACE__]);

        Route::fixed('ga', function () {
            Route::group(['prefix' => 'api', 'middleware' => 'settings'], function () {
                Route::get('visit', ['as' => 'plugin.ga.api.visit', 'uses' => 'ApiController@visit']);
                Route::get('browser', ['as' => 'plugin.ga.api.browser', 'uses' => 'ApiController@browser']);
                Route::get('source', ['as' => 'plugin.ga.api.source', 'uses' => 'ApiController@source']);
                Route::get('pv', ['as' => 'plugin.ga.api.pv', 'uses' => 'ApiController@pv']);
                Route::get('device', ['as' => 'plugin.ga.api.device', 'uses' => 'ApiController@device']);

                Route::get('test', ['as' => 'plugin.ga.api.test', 'uses' => 'ApiController@test']);
            });
        }, ['namespace' => __NAMESPACE__]);
    }

    private function registerEvent()
    {
        intercept('Presenter@make', 'googleAnalytics.addScript', function($target, $id, $data = [], $mergeData = [], $html = true, $api = false) {
            /** @var \Illuminate\Routing\Route $route */
            $route = app('router')->current();
            if (in_array('settings', $route->middleware()) === false) {
                $setting = app('xe.plugin.ga.handler')->getSetting();
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
}
