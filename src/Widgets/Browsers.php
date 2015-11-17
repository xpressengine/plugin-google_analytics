<?php
namespace Xpressengine\Plugins\GoogleAnalytics\Widgets;

use Exception;
use View;

class Browsers extends AbstractAnalytics
{
    public function render()
    {
        $days = isset($this->args['days']) ? $this->args['days'] : 30;
        $limit = isset($this->args['limit']) ? $this->args['limit'] : 5;

        try {
            $data = $this->analytics->data_ga->get(
                $this->getGaId(),
                $days . 'daysAgo',
                'today',
                'ga:visits',
                ['dimensions' => 'ga:browser', 'sort' => '-ga:visits']
            );
        } catch (Exception $e) {
            return View::make('ga::widget.error', ['message' => $e->getMessage()]);
        }

        $rows = $data->getRows() ?: [];
        $rows = array_slice($rows, 0, $limit);

        $jsonData = json_enc($rows);

        return View::make('ga::widget.browsers', [
            'jsonData' => $jsonData,
        ]);
    }
}
