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

namespace Xpressengine\Plugins\GoogleAnalytics\Skins;


class Devices extends AnalyticsWidgetSkin
{
    public function render()
    {
        return view('ga::widgets.devices', [
            'startdate' => array_get($this->data, 'startdate'),
            'title' => $this->getAttribute('title'),
        ]);
    }
}
