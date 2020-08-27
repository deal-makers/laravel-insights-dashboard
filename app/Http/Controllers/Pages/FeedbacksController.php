<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Detection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\User;

class FeedbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curUserId = Auth::user()->id;
        $decList = [];
        //$detections = Detection::query()->where('client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
        //$detections = $decModel->where('client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
//        $decList =  Detection::where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
//                leftJoin('dec_attachments', 'detections.id', '=', 'dec_attachments.parent_id')->select('detections.id', 'detections.dec_id', 'detections.title', 'detections.description',
//                'detections.detection_level', 'detections.created_at', 'detections.type', 'dec_attachments.mark_read', 'dec_attachments.feedback')->get();

        if(Auth::user()->hasRole('administrator'))
        {
            $decList =  Detection::all();
        } else
        {
            $decList =  Detection::where('detections.user_id', '=', $curUserId)->get();
        }

        $detections = [];
        foreach ($decList as $row)
        {
            $res = $row->dec_attachment()->get();
            if(sizeof($res) == 1)
            {
                $row->mark_read = $res[0]->mark_read;
                $row->feedback = $res[0]->feedback;
            } else
            {
                $row->mark_read = 0;
                $row->feedback = null;
            }
            $detections[] = $row;
        }
        return view('pages.feedbacks.index', compact('detections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
