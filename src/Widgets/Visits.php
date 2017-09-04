<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

class Visits extends AbstractAnalytics
{
    protected $defaults = [
        'startdate' => '7daysAgo',
        'unit' => 'date',
    ];

    public function render()
    {
        $config = $this->setting();

        return $this->renderSkin([
            'startdate' => array_get($config, 'startdate', $this->defaults['startdate']),
            'unit' => array_get($config, 'unit', $this->defaults['unit']),
        ]);
    }

    public function renderSetting(array $args = [])
    {
        return view('ga::widgets.settings.visits', [
            'startdate' => array_get($args, 'startdate'),
        ]);
    }
}
