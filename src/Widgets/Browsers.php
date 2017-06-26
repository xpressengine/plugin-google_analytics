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
    public function render()
    {
        $config = $this->setting();
        $days = array_get($config, 'days', 30);
        $limit = array_get($config, 'limit', 5);

        return $this->renderSkin([
            'days' => $days,
            'limit' => $limit,
        ]);
    }

    public function renderSetting(array $args = [])
    {

    }
}
