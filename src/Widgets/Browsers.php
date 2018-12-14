<?php
/**
 * Plugin.php
 *
 * This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

/**
 * Plugin
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */
class Browsers extends AbstractAnalytics
{
    protected $defaults = [
        'startdate' => '7daysAgo',
        'limit' => 5,
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
            'limit' => array_get($config, 'limit', $this->defaults['limit']),
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
        return view('ga::widgets.settings.browsers', [
            'startdate' => array_get($args, 'startdate', $this->defaults['startdate']),
            'limit' => array_get($args, 'limit', $this->defaults['limit']),
        ]);
    }
}
