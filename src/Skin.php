<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use View;
use Xpressengine\Skin\AbstractSkin;

class Skin extends AbstractSkin
{
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
        //
    }
}
