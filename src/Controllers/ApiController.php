<?php
/**
 * AnalyticsController.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Xpressengine\Http\Request;
use Xpressengine\Plugins\GoogleAnalytics\Handler;

class ApiController extends Controller
{
    public function visit(Request $request, Handler $handler)
    {
        $startdate = $request->get('startdate', '7daysAgo');
        $enddate = $request->get('enddate', 'today');
        $unit = $request->get('unit', 'date');

        $rows = $handler->getData($startdate, $enddate, 'ga:visits', [
            'dimensions' => 'ga:' . $unit
        ]);

        return response()->json($rows);
    }

    public function term(Request $request, Handler $handler)
    {
        $startyear = $request->get('startyear', date('Y'));
        $startmon = $request->get('startmon', 1);
        $endyear = $request->get('endyear', date('Y'));
        $endmon = $request->get('endmon', 12);
        $unit = $request->get('unit', 'day');

        $startdate = Carbon::createFromDate($startyear, $startmon)->startOfMonth()->format('Y-m-d');
        $enddate = Carbon::createFromDate($endyear, $endmon)->endOfMonth()->format('Y-m-d');

        $rows = $handler->getData($startdate, $enddate, 'ga:visits', [
            'dimensions' => 'ga:' . $unit
        ]);

        return response()->json($rows);
    }

    public function browser(Request $request, Handler $handler)
    {
        $startdate = $request->get('startdate', '7daysAgo');
        $enddate = $request->get('enddate', 'today');
        $limit = $request->get('limit', 5);

        $rows = $handler->getData($startdate, $enddate, 'ga:visits', [
            'dimensions' => 'ga:browser',
            'sort' => '-ga:visits',
            'max-results' => $limit
        ]);

        return response()->json($rows);
    }

    public function source(Request $request, Handler $handler)
    {
        $startdate = $request->get('startdate', '7daysAgo');
        $enddate = $request->get('enddate', 'today');
        $limit = $request->get('limit', 5);

        $rows = $handler->getData($startdate, $enddate, 'ga:visits', [
            'dimensions' => 'ga:source',
            'sort' => '-ga:visits',
            'max-results' => $limit
        ]);

        return response()->json($rows);
    }

    public function pv(Request $request, Handler $handler)
    {
        $startdate = $request->get('startdate', '7daysAgo');
        $enddate = $request->get('enddate', 'today');
        $limit = $request->get('limit', 5);

        $rows = $handler->getData($startdate, $enddate, 'ga:pageviews', [
            'dimensions' => 'ga:pagePath',
            'sort' => '-ga:pageviews',
            'max-results' => $limit
        ]);

        return response()->json($rows);
    }

    public function device(Request $request, Handler $handler)
    {
        $startdate = $request->get('startdate', '7daysAgo');
        $enddate = $request->get('enddate', 'today');

        $rows = $handler->getData($startdate, $enddate, 'ga:visits', [
            'dimensions' => 'ga:deviceCategory',
            'sort' => '-ga:deviceCategory'
        ]);

        return response()->json($rows);
    }

    public function page(Request $request, Handler $handler)
    {
        $startdate = $request->get('startdate', '7daysAgo');
        $enddate = $request->get('enddate', 'today');
        $path = rawurldecode($request->get('path') ?: '/');

        $rows = $handler->getData($startdate, $enddate, 'ga:pageviews', [
            'dimensions' => 'ga:date',
            'filters' => 'ga:pagePath==' . $path
        ]);

        return response()->json($rows);
    }

    public function test()
    {
    }
}
