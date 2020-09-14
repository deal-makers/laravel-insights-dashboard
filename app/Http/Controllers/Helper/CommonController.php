<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommonController extends Controller
{
    /**
     * Register session date ragne.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String yyyy-mm-dd $endDate
     * @return \Illuminate\Http\Response
     */
    public function ajaxSessionDateRange(Request $request)
    {
        if(request()->ajax()) {
            //String yyyy-mm-dd $startDate
            //String yyyy-mm-dd $endDate
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            session()->put('start_date', $startDate);
            session()->put('end_date', $endDate);
            return new JsonResponse([], 200);
        }
    }
}
