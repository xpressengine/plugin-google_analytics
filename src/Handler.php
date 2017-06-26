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
            $client->setAuthConfig(json_decode($this->getSetting()->getKeyContent(), true));

            // scopes: https://developers.google.com/identity/protocols/googlescopes
            $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithAssertion();
            }

            $this->analytics = new Google_Service_Analytics($client);
        }

        return $this->analytics;
    }

    private function checkConfiguration()
    {
        return $this->getSetting('profileId')
            && $this->getSetting()->getKeyContent();
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
