<?php
/**
 * Visits.php
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

namespace Xpressengine\Plugins\GoogleAnalytics\Skins;

/**
 * Visits
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Visits extends AnalyticsWidgetSkin
{
    /**
     * render
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('ga::widgets.visits', [
            'unit' => array_get($this->data, 'unit'),
            'startdate' => array_get($this->data, 'startdate'),
            'title' => $this->getAttribute('title'),
        ]);
    }
}
