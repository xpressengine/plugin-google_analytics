<?php
/**
 * Handler.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Google_Client;
use Google_Service_Analytics;
use Illuminate\Foundation\Application;
use LogicException;
use Xpressengine\Widget\Exceptions\NotConfigurationWidgetException;

class Handler
{
    protected $app;

    protected $setting;

    protected $analytics;

    public function __construct(Application $app, Setting $setting)
    {
        $this->app = $app;
        $this->setting = $setting;
    }

    public function getVisitData($startDate, $endDate)
    {
        $data = $this->getAnalytics()->data_ga->get(
            $this->getGaId(),
            $startDate,
            $endDate,
            'ga:visits',
            ['dimensions' => 'ga:date']
        );


        $rows = [];
        foreach ($data->getRows() as $row) {
            $rows[] = [strtotime($row[0]) * 1000, $row[1]];
        }

        return $rows;
    }

    public function getBrowserData($startDate, $endDate, $limit)
    {
        $data = $this->getAnalytics()->data_ga->get(
            $this->getGaId(),
            $startDate,
            $endDate,
            'ga:visits',
            ['dimensions' => 'ga:browser', 'sort' => '-ga:visits']
        );


        $rows = $data->getRows() ?: [];
        $rows = array_slice($rows, 0, $limit);

        return $rows;
    }

    public function getVisitSourceData($startDate, $endDate, $limit)
    {
        $data = $this->getAnalytics()->data_ga->get(
            $this->getGaId(),
            $startDate,
            $endDate,
            'ga:visits',
            ['dimensions' => 'ga:source', 'sort' => '-ga:visits']
        );

        $rows = $data->getRows() ?: [];
        $rows = array_slice($rows, 0, $limit);

        return $rows;
    }

    public function getPageViewData($startDate, $endDate, $limit)
    {
        $data = $this->getAnalytics()->data_ga->get(
            $this->getGaId(),
            $startDate,
            $endDate,
            'ga:pageviews',
            ['dimensions' => 'ga:pagePath', 'sort' => '-ga:pageviews']
        );

        $rows = $data->getRows() ?: [];
        $rows = array_slice($rows, 0, $limit);

        return $rows;
    }

    protected function getGaId()
    {
        return 'ga:' . $this->getSetting('profileId');
    }

    protected function getAnalytics()
    {
        if ($this->checkConfiguration() !== true) {
            throw new NotConfigurationWidgetException;
        }

        if (!$this->analytics) {
            $client = new Google_Client();
            $this->setAuthConfig($client, $this->getSetting()->getKeyContent());

            // scopes: https://developers.google.com/identity/protocols/googlescopes
            $client->addScope(['https://www.googleapis.com/auth/analytics']);

            $this->analytics = new Google_Service_Analytics($client);
        }

        return $this->analytics;
    }

    private function checkConfiguration()
    {
        return $this->getSetting('profileId')
            && $this->getSetting()->getKeyContent();
    }

    protected function setAuthConfig(Google_Client $client, $json)
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

    public function getSetting($key = null)
    {
        return !$key ? $this->setting : $this->setting->get($key);
    }

    protected function getService($service = null)
    {
        return !$service ? $this->app : $this->app[$service];
    }
}
