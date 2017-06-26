<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

class Visits extends AbstractAnalytics
{
    public function render()
    {
        /*
         * 설정항목:
         *  일/월/년 단위 설정 (day/month/year)
         *  기간설정 (start ~ end) widget 에서는 start 만 받고 오늘까지로?
         */
        $config = $this->setting();
        $unit = array_get($config, 'unit', 'day');
        $days = array_get($config, 'days', 30);

        return $this->renderSkin([
            'unit' => $unit,
            'days' => $days,
        ]);
    }

    public function renderSetting(array $args = [])
    {
//        return view('ga::widgetForm', [
//            'types' => $this->types,
//            'selected' => Arr::get($args, 'type'),
//            'prettyType' => function ($type) {
//                return ucwords(str_replace('_', ' ', Str::snake($type)));
//            }
//        ]);
    }
}
