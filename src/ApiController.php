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

namespace Xpressengine\Plugins\GoogleAnalytics;

use App\Http\Controllers\Controller;
use Xpressengine\Http\Request;

class ApiController extends Controller
{
    public function visit(Request $request, Handler $handler)
    {
        $days = $request->get('days', 30);

        $rows = $handler->getVisitData(
            $days . 'daysAgo',
            'today'
        );

        return response()->json($rows);
    }

    public function browser(Request $request, Handler $handler)
    {
        $days = $request->get('days', 30);
        $limit = $request->get('limit', 5);

        $rows = $handler->getBrowserData(
            $days . 'daysAgo',
            'today',
            $limit
        );

        return response()->json($rows);
    }

    public function source(Request $request, Handler $handler)
    {
        $days = $request->get('days', 30);
        $limit = $request->get('limit', 5);

        $rows = $handler->getVisitSourceData(
            $days . 'daysAgo',
            'today',
            $limit
        );

        return response()->json($rows);
    }

    public function pv(Request $request, Handler $handler)
    {
        $days = $request->get('days', 30);
        $limit = $request->get('limit', 5);

        $rows = $handler->getPageViewData(
            $days . 'daysAgo',
            'today',
            $limit
        );

        return response()->json($rows);
    }
}
