<?php
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
