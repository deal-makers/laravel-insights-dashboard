<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Detection;
use App\Models\Tags;
use App\User;
use phpDocumentor\Reflection\DocBlock\Tag;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detection_cnt = Detection::query()->select('type', DB::raw('count(*) as count'))->groupBy('type')->orderBy('count', 'desc')->get();
        $notification_icons = ['fe-rss', 'fe-share-2', 'fe-zap', 'fe-tv', 'fe-crop', 'fe-shield-off', 'fe-gitlab', 'fe-bold', 'fe-wifi-off'];

        $takedown_cnt = User::whereHas(
                'roles', function($q){
                    $q->where('name', 'client');
                })->sum('takedowns');

        $detection_count_level = Detection::query()->select('detection_level', DB::raw('count(*) as count'))->groupBy('detection_level')->orderBy('count', 'desc')->limit(4)->get();
        //$tag_list = Tags::query()->orderBy('group')->groupBy('group')->select( 'group', \DB::raw("GROUP_CONCAT(id, '::', tag) as tags"))->get();
        $tag_list = Detection::query()->select('tags', 'ioc')->get();
        $tags = Tags::query()->select('id', 'tag')->get();
        $tag_ranking = [];
        foreach ($tags as $tag)
        {
            $curCnt = 0;
            $tag_ranking[$tag->tag] = 0;
            foreach ($tag_list as $row)
            {
               $curTagList =  unserialize($row->tags);
               foreach ($curTagList as $val)
               {
                   if($tag->id == $val)
                       $tag_ranking[$tag->tag] ++;
               }
            }
        }
        arsort($tag_ranking);
        $tag_ranking = array_diff($tag_ranking, [0]);

        //get IOC Frequency of appearance//
        $curIocList = [];
        foreach ($tag_list as $row)
        {
            if(is_null($row->ioc) || $row->ioc == '') continue;
            $newIocArray = [];
            $iocVal = unserialize($row->ioc);
            foreach ($iocVal as $key => $ioc)
            {
                $newIocArray[] = $key.'|*\/*|'.$ioc;
            }
            $curIocList = array_merge($curIocList, $newIocArray);
        }
        $iocRes = [];
        for($index = 0; $index < sizeof($curIocList); $index++)
        {
            $cnt = 0;
            for($indexY = 1; $indexY < sizeof($curIocList) - 1; $indexY++)
            {
                if($curIocList[$index] == $curIocList[$indexY])
                {
                    $cnt ++;
                }
            }
            if($cnt == 0) $cnt = 1;
            $iocRes[$curIocList[$index]] = $cnt;
        }
        arsort($iocRes);
        $iocRes = array_slice($iocRes, 0, 5);

        //weeklyCount and monthly Count//
        $curYear = date('Y');
        $curMonth = date('m');
        $decMonthlyCount = [];
        for($mon = 1; $mon <= $curMonth; $mon++)
        {
            $monthVal = $mon;
            if(strlen($mon) == 1) $monthVal = '0'.$mon;
            $calDate = $curYear . '-' . $monthVal;
            $detection_count = Detection::query()->select( DB::raw('count(*) as count'))->where('created_at', 'like', $calDate.'%')->get();
            if(sizeof($detection_count) > 0)
            {
                $decMonthlyCount[$calDate] = $detection_count[0]->count;
            }
        }

        $decWeeklyCount = [];
        $curDate = date('Y-m-d');
        $currentWeek = $this->rangeWeek($curDate);
        $curWeekDates = $this->displayDates($currentWeek['start'], $currentWeek['end']);
        foreach ($curWeekDates as $val)
        {
            $detection_count = Detection::query()->select( DB::raw('count(*) as count'))->where('created_at', 'like', $val.'%')->get();
            $decWeeklyCount[$val] = $detection_count[0]->count;
        }
        return view('pages.dashboard', compact('detection_cnt', 'takedown_cnt', 'detection_count_level', 'tag_ranking',
            'iocRes', 'decMonthlyCount', 'decWeeklyCount', 'notification_icons'));
    }

    /**
     * Get current weekly date.
     * @param 'Y-m-d' $datestr
     * @return array
     */
    public function rangeWeek ($datestr) {
        date_default_timezone_set (date_default_timezone_get());
        $dt = strtotime ($datestr);
        return array (
            "start" => date ('N', $dt) == 1 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('last monday', $dt)),
            "end" => date('N', $dt) == 7 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('next sunday', $dt))
        );
    }

    /**
     * Get current weekly date.
     * @param 'Y-m-d' $date1
     * @param 'Y-m-d' $date2
     * @param 'Y-m-d' $format
     * @return array
     */
    public function displayDates($date1, $date2, $format = 'Y-m-d' )
    {
        $dates = array();
        $current = strtotime($date1);
        $date2 = strtotime($date2);
        $stepVal = '+1 day';
        while( $current <= $date2 ) {
            $dates[] = date($format, $current);
            $current = strtotime($stepVal, $current);
        }
        return $dates;
    }
}
