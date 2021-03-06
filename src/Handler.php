<?php
/**
 * Handler.php
 *
 * This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Google_Client;
use Google_Service_Analytics;
use Illuminate\Foundation\Application;
use Xpressengine\Widget\Exceptions\NotConfigurationWidgetException;

/**
 * Handler
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Handler
{
    protected $app;

    protected $setting;

    protected $analytics;

    /**
     * Handler constructor.
     *
     * @param Application $app     app
     * @param Setting     $setting setting
     */
    public function __construct(Application $app, Setting $setting)
    {
        $this->app = $app;
        $this->setting = $setting;
    }

    /**
     * get data
     *
     * @param string $startDate start date
     * @param string $endDate   end date
     * @param mixed  $metrics   metrics
     * @param array  $opts      opts
     *
     * @return array
     */
    public function getData($startDate, $endDate, $metrics, array $opts)
    {
        $data = $this->getAnalytics()->data_ga->get(
            $this->getGaId(),
            $startDate,
            $endDate,
            $metrics,
            $opts
        );

        return $data->getRows() ?: [];
    }

    /**
     * get GA id
     * @return string
     */
    protected function getGaId()
    {
        return 'ga:' . $this->getSetting('profileId');
    }

    /**
     * get analytics
     *
     * @return Google_Service_Analytics
     */
    public function getAnalytics()
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

    /**
     * check configuration
     *
     * @return bool
     */
    private function checkConfiguration()
    {
        return $this->getSetting('profileId')
            && $this->getSetting()->getKeyContent();
    }

    /**
     * get setting
     *
     * @param null|string $key key
     *
     * @return mixed|Setting|null
     */
    public function getSetting($key = null)
    {
        return !$key ? $this->setting : $this->setting->get($key);
    }

    /**
     * get service
     *
     * @param null|string $service service
     *
     * @return Application|mixed
     */
    protected function getService($service = null)
    {
        return !$service ? $this->app : $this->app[$service];
    }
}
