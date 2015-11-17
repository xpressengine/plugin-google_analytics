<?php
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
