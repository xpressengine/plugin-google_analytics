<?php
/**
 * Browsers.php
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


class Browsers extends AnalyticsWidgetSkin
{
    public function render()
    {
        return view('ga::widgets.browsers', [
            'days' => array_get($this->data, 'days'),
            'limit' => array_get($this->data, 'limit'),
            'title' => $this->getAttribute('title'),
        ]);
    }
}
