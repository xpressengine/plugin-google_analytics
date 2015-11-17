<?php
namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

use Exception;
use View;

class VisitSources extends AbstractAnalytics
{
    public function render()
    {
        $days = isset($this->args['days']) ? $this->args['days'] : 30;
        $limit = isset($this->args['limit']) ? $this->args['limit'] : 7;

        try {
            $data = $this->analytics->data_ga->get(
                $this->getGaId(),
                $days . 'daysAgo',
                'today',
                'ga:visits',
                ['dimensions' => 'ga:source', 'sort' => '-ga:visits']
            );
        } catch (Exception $e) {
            return View::make('ga::widget.error', ['message' => $e->getMessage()]);
        }

        $rows = $data->getRows() ?: [];

        $rows = array_slice($rows, 0, $limit);
//        $total = $data->getTotalsForAllResults()['ga:visits'];

        $jsonData = json_enc($rows);

        return View::make('ga::widget.visitSources', [
            'jsonData' => $jsonData,
//            'rows' => $rows,
//            'total' => $total
        ]);
    }
}
