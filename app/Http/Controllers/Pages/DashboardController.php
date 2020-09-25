<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Support\Facades\Auth;
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
        $curDate = date('Y-m-d');
        $currentWeek = $this->rangeWeek($curDate);

        $start_date = session()->get('start_date');
        if (!isset($start_date)) {
            session()->put('start_date', $currentWeek['start']);
            session()->put('end_date', $currentWeek['end']);
        }

        $start_date = session()->get('start_date');
        $end_date = session()->get('end_date');

        $detection_count_list = [];

        $curUserId = Auth::user()->id;

        foreach (session('dec_type') as $key => $value) {
            if(Auth::user()->hasRole('client'))
            {
                $detection_cnt = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])->where('type', '=', $key)
                    ->where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')
                    ->select(DB::raw('count(*) as count'))
                    ->groupBy('type')->orderBy('count', 'desc')->get();
            } else
            {
                $detection_cnt = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])->where('type', '=', $key)->select(DB::raw('count(*) as count'))
                    ->groupBy('type')->orderBy('count', 'desc')->get();
            }


            if (sizeof($detection_cnt) > 0)
                $detection_count_list[$key] = $detection_cnt[0]->count;
            else
                $detection_count_list[$key] = 0;
        }
        arsort($detection_count_list);

        if(Auth::user()->hasRole('client')) {
            $takedown_cnt = User::whereHas(
                'roles', function ($q) {
                $q->where('name', 'client');
            })->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])
                ->where('id', '=', $curUserId)
                ->sum('takedowns');
        } else {
            $takedown_cnt = User::whereHas(
                'roles', function ($q) {
                $q->where('name', 'client');
            })->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])
                ->sum('takedowns');
        }

        $detection_count_list[sizeof(session('dec_type'))] = (int)$takedown_cnt;


        $notification_icons = ['fe-rss', 'fe-share-2', 'fe-zap', 'fe-tv', 'fe-crop', 'fe-shield-off', 'fe-gitlab', 'fe-bold', 'fe-wifi-off', 'mdi mdi-rotate-225 mdi-account'];
        $notification_colors = ['danger', 'warning', 'success', 'primary', 'blue', 'pink', 'info', 'warning', 'primary', 'dark'];

        if(Auth::user()->hasRole('client')) {
            $detection_count_level = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])
                ->where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')
                ->select('detection_level', DB::raw('count(*) as count'))->groupBy('detection_level')->orderBy('count', 'desc')->limit(4)->get();
        } else
        {
            $detection_count_level = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])->select('detection_level', DB::raw('count(*) as count'))->groupBy('detection_level')->orderBy('count', 'desc')->limit(4)->get();
        }
        if(Auth::user()->hasRole('client')) {
            $tag_list = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])
                ->where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')
                ->select('tags', 'ioc', 'id', 'dec_id')->get();
        } else
        {
            $tag_list = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])->select('tags', 'ioc', 'id', 'dec_id')->get();
        }

        $tags = Tags::query()->select('id', 'tag')->get();
        $tag_ranking = [];
        foreach ($tags as $tag) {
            $curCnt = 0;
            $tag_ranking[$tag->tag] = 0;
            foreach ($tag_list as $row) {
                $curTagList = unserialize($row->tags);
                foreach ($curTagList as $val) {
                    if ($tag->id == $val)
                        $tag_ranking[$tag->tag]++;
                }
            }
        }

        arsort($tag_ranking);
        $tag_ranking = array_diff($tag_ranking, [0]);

        //get IOC Frequency of appearance//
        $curIocList = [];
        foreach ($tag_list as $row) {
            if (is_null($row->ioc) || $row->ioc == '') continue;
            $newIocArray = [];
            $iocVal = unserialize($row->ioc);
            foreach ($iocVal as $key => $ioc) {
                $newIocArray[] = [$key . '|*\/*|' . $ioc, $row->id, $row->dec_id];
            }
            $curIocList = array_merge($curIocList, $newIocArray);
        }

        $iocRes = [];
        for ($index = 0; $index < sizeof($curIocList); $index++) {
            $cnt = 0;
            for ($indexY = 1; $indexY < sizeof($curIocList) - 1; $indexY++) {
                if ($curIocList[$index][0] == $curIocList[$indexY][0]) {
                    $cnt++;
                }
            }
            if ($cnt == 0) $cnt = 1;
            $iocRes[$curIocList[$index][0]] = [$cnt, $curIocList[$index][1], $curIocList[$index][2]];
        }

        arsort($iocRes);
        $iocRes = array_slice($iocRes, 0, 5);

        //DailyCount
        $decDailyCount = [];
        if(Auth::user()->hasRole('client')) {
            $dailyCntLst = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])
                ->where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')
                ->select(DB::raw('DATE(created_at) as dt'), DB::raw('count(*) as count'))->groupBy(DB::raw('DATE(created_at)'))->orderBy('dt', 'asc')->get();
        } else
        {
            $dailyCntLst = Detection::query()->whereBetween(DB::raw("DATE(created_at)"), [$start_date, $end_date])->select(DB::raw('DATE(created_at) as dt'), DB::raw('count(*) as count'))->groupBy(DB::raw('DATE(created_at)'))->orderBy('dt', 'asc')->get();
        }
        foreach ($dailyCntLst as $row)
        {
            $decDailyCount[$row->dt] = $row->count;
        }

        //weeklyCount and monthly Count//
        $curYear = date('Y');
        $curMonth = date('m');
        $decMonthlyCount = [];
        for($mon = 1; $mon <= $curMonth; $mon++)
        {
            $monthVal = $mon;
            if(strlen($mon) == 1) $monthVal = '0'.$mon;
            $calDate = $curYear . '-' . $monthVal;
            if(Auth::user()->hasRole('client')) {
                $detection_count = Detection::query()->select( DB::raw('count(*) as count'))
                    ->where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')
                    ->where('created_at', 'like', $calDate.'%')->get();
            } else
            {
                $detection_count = Detection::query()->select( DB::raw('count(*) as count'))->where('created_at', 'like', $calDate.'%')->get();
            }
            if(sizeof($detection_count) > 0)
            {
                $decMonthlyCount[$calDate] = $detection_count[0]->count;
            }
        }

        $decWeeklyCount = [];

        $curWeekDates = $this->displayDates($currentWeek['start'], $currentWeek['end']);
        foreach ($curWeekDates as $val)
        {
            if(Auth::user()->hasRole('client')) {
                $detection_count = Detection::query()->select(DB::raw('count(*) as count'))
                    ->where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')
                    ->where('created_at', 'like', $val . '%')->get();
            } else
            {
                $detection_count = Detection::query()->select(DB::raw('count(*) as count'))->where('created_at', 'like', $val . '%')->get();
            }
            $decWeeklyCount[$val] = $detection_count[0]->count;
        }
        return view('pages.dashboard', compact('detection_count_list', 'takedown_cnt', 'detection_count_level', 'tag_ranking',
            'iocRes', 'decDailyCount', 'decMonthlyCount', 'decWeeklyCount', 'notification_icons', 'notification_colors'));
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
