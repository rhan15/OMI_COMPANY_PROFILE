<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Config;
use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use App\Models\GAnalytics;

class GAnalyticsController extends Controller
{
    public function visitor(){
        $visitor = GAnalytics::visitor();
        return $visitor;
    }

    public function totalVisitor(){
        $total_visitor = GAnalytics::totalVisitor();
        return ($total_visitor);
    }

    public function pageview(){
        $pageviews = GAnalytics::pageviews();
        return $pageviews;
    }
}