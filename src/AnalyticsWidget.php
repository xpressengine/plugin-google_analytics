<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Google_Client;
use Google_Auth_AssertionCredentials;
use Google_Service_Analytics;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LogicException;
use Xpressengine\Widget\AbstractWidget;
use XeFrontend;
use Xpressengine\Widget\Exceptions\NotConfigurationWidgetException;

class AnalyticsWidget extends AbstractWidget
{
    /**
     * @var Setting
     */
    protected $setting;

    protected $types = ['dailyVisits', 'visitSources', 'browsers', 'pageViews'];
    
    protected function init()
    {
        $this->setting = app('xe.plugin.ga')->getSetting();
    }

    public function render()
    {
        $type = array_get($this->config, 'type');
        if (!in_array($type, $this->types)) {
            throw new \Exception("Unknown widget type [{$type}]");
        }

        if ($this->checkConfiguration() !== true) {
            throw new NotConfigurationWidgetException;
        }

        $class = __NAMESPACE__ . '\\Widgets\\' . ucfirst($type);
        if (class_exists(ucfirst($class)) !== true) {
            throw new \Exception("Unknown type [{$type}]");
        }

        XeFrontend::js('https://www.google.com/jsapi')->appendTo('head')->load();
        /** @var \Xpressengine\Plugins\GoogleAnalytics\Widgets\AbstractAnalytics $widget */
        $widget = new $class($this->getAnalytics(), $this->setting->get('profileId'), $this->config);

        return $this->renderSkin([
            'widget' => $widget
        ]);
    }

    private function getAnalytics()
    {
        $client = new Google_Client();
        $this->setAuthConfig($client, $this->setting->getKeyContent());
        $client->addScope(['https://www.googleapis.com/auth/analytics']);

        return new Google_Service_Analytics($client);
    }

    private function checkConfiguration()
    {
        return $this->setting->get('profileId')
            && $this->setting->getKeyContent();
    }

    public function renderSetting(array $args = [])
    {
        return view('ga::widgetForm', [
            'types' => $this->types,
            'selected' => Arr::get($args, 'type'),
            'prettyType' => function ($type) {
                return ucwords(str_replace('_', ' ', Str::snake($type)));
            }
        ]);
    }

    public function setAuthConfig(Google_Client $client, $json)
    {
        if (!$config = json_decode($json, true)) {
            throw new LogicException('invalid json for auth config');
        }

        $key = isset($config['installed']) ? 'installed' : 'web';
        if (isset($config['type']) && $config['type'] == 'service_account') {
            // application default credentials
            $client->useApplicationDefaultCredentials();

            // set the information from the config
            $client->setClientId($config['client_id']);
            $client->setConfig('client_email', $config['client_email']);
            $client->setConfig('signing_key', $config['private_key']);
            $client->setConfig('signing_algorithm', 'HS256');
        } elseif (isset($config[$key])) {
            // old-style
            $client->setClientId($config[$key]['client_id']);
            $client->setClientSecret($config[$key]['client_secret']);
            if (isset($config[$key]['redirect_uris'])) {
                $client->setRedirectUri($config[$key]['redirect_uris'][0]);
            }
        } else {
            // new-style
            $client->setClientId($config['client_id']);
            $client->setClientSecret($config['client_secret']);
            if (isset($config['redirect_uris'])) {
                $client->setRedirectUri($config['redirect_uris'][0]);
            }
        }
    }
}
