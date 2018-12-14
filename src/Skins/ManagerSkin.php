<?php
/**
 * ManagerSkin.php
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

namespace Xpressengine\Plugins\GoogleAnalytics\Skins;

use View;
use Xpressengine\Skin\AbstractSkin;

/**
 * ManagerSkin
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */
class ManagerSkin extends AbstractSkin
{
    /**
     * render
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return View::make('ga::' . $this->view, $this->data);
    }

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
    }
}
