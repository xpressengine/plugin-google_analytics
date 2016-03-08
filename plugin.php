<?php
namespace Xpressengine\Plugins\GoogleAnalytics;

use Xpressengine\Plugin\AbstractPlugin;
use XeFrontend;
use Route;
use View;

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
            $app = app();
            $router = $app['router'];

            /** @var \Illuminate\Routing\Route $route */
            $route = $router->current();
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
