<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

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
