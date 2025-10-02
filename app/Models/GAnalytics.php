<?php

namespace App\Models;
use Carbon\Carbon;
use Exception;

use Illuminate\Database\Eloquent\Model;

use Analytics;
use Spatie\Analytics\Period;
use App\Libraries\GoogleAnalytics;

class GAnalytics extends Model
{
    public static function visitor()
    {
        $visitors = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
        return $visitors;
    }

    public static function totalVisitor(){
        // $startDate = Carbon::create(2020, 10, 1, 0, 0, 0);
        // $endDate = Carbon::now();

        $total_visitors = Analytics::fetchTotalVisitorsAndPageViews(Period::months(1));
        return $total_visitors;
    }

    public static function pageviews(){
        // $startDate = Carbon::create(2020, 11, 20, 0, 0, 0);
        // $endDate = Carbon::now();
        // $pages = Analytics::fetchMostVisitedPages(Period::create($startDate, $endDate));

        $pages = Analytics::fetchMostVisitedPages(Period::days(7));

        return $pages;
    }
}
