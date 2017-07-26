<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

class Browsers extends AbstractAnalytics
{
    protected $defaults = [
        'startdate' => '7daysAgo',
        'limit' => 5,
    ];

    public function render()
    {
        $config = $this->setting();

        return $this->renderSkin([
            'startdate' => array_get($config, 'startdate', $this->defaults['startdate']),
            'limit' => array_get($config, 'limit', $this->defaults['limit']),
        ]);
    }

    public function renderSetting(array $args = [])
    {
        return view('ga::widgets.settings.browsers', [
            'startdate' => array_get($args, 'startdate', $this->defaults['startdate']),
            'limit' => array_get($args, 'limit', $this->defaults['limit']),
        ]);
    }
}
