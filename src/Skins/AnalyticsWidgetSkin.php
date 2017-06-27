<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Skins;

use XeFrontend;
use Xpressengine\Skin\AbstractSkin;

class AnalyticsWidgetSkin extends AbstractSkin
{
    public function __construct($config = null)
    {
        parent::__construct($config);

        XeFrontend::js('https://www.gstatic.com/charts/loader.js')->appendTo('body')->load();
        XeFrontend::html('ga:chartload')->content(
            "<script>google.charts.load('current', {packages:['corechart'], 'language':'ko'});</script>"
        )->load();
    }

    public function getAttribute($name)
    {
        return array_get($this->setting(), "@attributes.{$name}");
    }
}
