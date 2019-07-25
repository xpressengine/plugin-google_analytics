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

namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

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
class Visits extends AbstractAnalytics
{
    protected $defaults = [
        'startdate' => '7daysAgo',
        'unit' => 'date',
    ];

    /**
     * render
     *
     * @return string
     */
    public function render()
    {
        $config = $this->setting();

        return $this->renderSkin([
            'startdate' => array_get($config, 'startdate', $this->defaults['startdate']),
            'unit' => array_get($config, 'unit', $this->defaults['unit']),
        ]);
    }

    /**
     * render setting
     *
     * @param array $args args
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function renderSetting(array $args = [])
    {
        return view('ga::widgets.settings.visits', [
            'startdate' => array_get($args, 'startdate'),
        ]);
    }
}
