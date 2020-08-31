<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Detection;
use App\User;

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
        $takedown_cnt = User::whereHas(
                'roles', function($q){
                    $q->where('name', 'client');
                })->sum('takedowns');

        $detection_count_level = Detection::query()->select('detection_level', DB::raw('count(*) as count'))->groupBy('detection_level')->orderBy('count', 'desc')->get();
        return view('pages.dashboard', compact('detection_cnt', 'takedown_cnt', 'detection_count_level'));
    }
}
