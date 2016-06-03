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

class PageViews extends AbstractAnalytics
{
    public function render()
    {
        $days = isset($this->args['days']) ? $this->args['days'] : 30;
        $limit = isset($this->args['limit']) ? $this->args['limit'] : 10;

        try {
            $data = $this->analytics->data_ga->get(
                $this->getGaId(),
                $days . 'daysAgo',
                'today',
                'ga:pageviews',
                ['dimensions' => 'ga:pagePath', 'sort' => '-ga:pageviews']
            );
        } catch (Exception $e) {
            return View::make('ga::widget.error', ['message' => $e->getMessage()]);
        }

        $rows = $data->getRows() ?: [];
        $rows = array_slice($rows, 0, $limit);

        $total = 0;
        foreach ($rows as $row) {
            $total += $row[1];
        }

        return View::make('ga::widget.pageViews', [
            'rows' => $rows,
            'total' => $total
        ]);
    }
}
