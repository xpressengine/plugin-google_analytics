<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

use Exception;
use View;

class DailyVisits extends AbstractAnalytics
{
    public function render()
    {
        $days = isset($this->args['days']) ? $this->args['days'] : 30;

        try {
            $data = $this->analytics->data_ga->get(
                $this->getGaId(),
                $days . 'daysAgo',
                'today',
                'ga:visits',
                ['dimensions' => 'ga:date']
            );
        } catch (Exception $e) {
            return View::make('ga::widget.error', ['message' => $e->getMessage()]);
        }

        $rows = [];
        foreach ($data->getRows() as $row) {
            $rows[] = [strtotime($row[0]) * 1000, $row[1]];
        }

        $jsonData = str_replace('"', '', json_encode($rows));

        return View::make('ga::widget.dailyVisit', [
            'jsonData' => $jsonData
        ]);
    }
}
