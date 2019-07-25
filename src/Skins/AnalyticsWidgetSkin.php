<?php
/**
 * AnalyticsWidgetSkin.php
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

use XeFrontend;
use Xpressengine\Skin\AbstractSkin;

/**
 * AnalyticsWidgetSkin
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AnalyticsWidgetSkin extends AbstractSkin
{
    /**
     * AnalyticsWidgetSkin constructor.
     *
     * @param null $config config
     */
    public function __construct($config = null)
    {
        parent::__construct($config);

        XeFrontend::js('https://www.gstatic.com/charts/loader.js')->appendTo('body')->load();
        XeFrontend::html('ga:chartload')->content(
            "<script>window.google.charts.load('current', {packages:['corechart'], 'language':'ko'});</script>"
        )->load();
    }

    /**
     * get attribute
     *
     * @param string $name name
     *
     * @return mixed
     */
    public function getAttribute($name)
    {
        return array_get($this->setting(), "@attributes.{$name}");
    }
}
