<?php
/**
 * Device.php
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

namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;


class Devices extends AbstractAnalytics
{
    protected $defaults = [
        'startdate' => '7daysAgo',
    ];

    public function render()
    {
        $config = $this->setting();

        return $this->renderSkin([
            'startdate' => array_get($config, 'startdate', $this->defaults['startdate']),
        ]);
    }

    public function renderSetting(array $args = [])
    {
        return view('ga::widgets.settings.sources', [
            'startdate' => array_get($args, 'startdate', $this->defaults['startdate']),
        ]);
    }
}