<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Skins;

use Xpressengine\Skin\AbstractSkin;

class AnalyticsWidgetSkin extends AbstractSkin
{
    public function render()
    {
        $widget = array_get($this->data, 'widget');

        return $widget->render();
    }
}
