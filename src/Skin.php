<?php
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
