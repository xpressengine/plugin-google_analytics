<?php
namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

use Google_Service_Analytics;

abstract class AbstractAnalytics
{
    protected $analytics;

    protected $profileId;

    protected $args;

    public function __construct(Google_Service_Analytics $analytics, $profileId, array $args = [])
    {
        $this->analytics = $analytics;
        $this->profileId = $profileId;
        $this->args = $args;
    }

    abstract public function render();

    protected function getGaId()
    {
        return 'ga:' . $this->profileId;
    }
}
