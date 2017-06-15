<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Illuminate\Contracts\Validation\Factory;
use Xpressengine\Plugin\AbstractPlugin;
use XeFrontend;
use Route;
use View;
use Xpressengine\Translation\Translator;

class Plugin extends AbstractPlugin
{
    public function boot()
    {
        app()->bind('xe.plugin.ga', function () {
            return $this;
        }, true);

        $this->registerRoute();
        $this->registerEvent();

        View::addNamespace('ga', __DIR__ . '/views');

        app(Factory::class)->extend('ga_json', function ($attr, $value) {
            return 'json' === $value->getClientOriginalExtension();
        }, 'The :attribute must be a file of type: json.');

        Translator::alias('google_analytics', 'ga');
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
    }

    private function registerEvent()
    {
        intercept('Presenter@make', 'googleAnalytics.addScript', function($target, $id, $data = [], $mergeData = [], $html = true, $api = false) {
            /** @var \Illuminate\Routing\Route $route */
            $route = app('router')->current();
            if (in_array('manage', $route->middleware()) === false) {
                $setting = $this->getSetting();
                if ($setting->get('trackingId')) {
                    XeFrontend::html('analytics')->content(
                        $this->getTrackingCode($setting->get('trackingId'), $setting->get('domain', 'auto'))
                    )->load();
                }
            }

            return $target($id, $data, $mergeData, $html, $api);
        });
    }

    public function getSetting()
    {
        return new Setting(app('xe.config'), app('xe.storage'), app('xe.keygen'));
    }

    private function getTrackingCode($trackingId, $domain = 'auto')
    {
        return View::make('ga::tracking', compact('trackingId', 'domain'));
    }

    public function pluginPath()
    {
        return __DIR__;
    }

    public function assetPath()
    {
        return str_replace(base_path(), '', $this->pluginPath()) . '/assets';
    }
}
