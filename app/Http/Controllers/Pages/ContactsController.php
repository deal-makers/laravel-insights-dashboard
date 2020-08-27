<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Detection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\User;
use Mail;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('analyst'))
        {


        } else
        {

            $contact_reason = session('contact_reason');
            $curUserId = Auth::user()->id;
            $detections =  Detection::where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get()->pluck('dec_id', 'id');
            return view('pages.contacts.create', compact('contact_reason', 'detections'));
        }
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
        $request->validate(
            [
                'reason' => 'required',
                'dec_id' => 'required',
                'contents'  => 'required'
            ]
        );
        $sendType = $request->send_type;
        //Db store
        $client_id = $request->user()->id;
        $detection_id = $request->dec_id;
        $reason = $request->reason;
        $contents = $request->contents;
        Contact::query()->updateOrInsert(['client_id' => $client_id, 'detection_id' => $detection_id, 'contact_reason' => $reason], ['client_id' => $client_id, 'detection_id' => $detection_id,
            'contact_reason' => $reason, 'contents' => $contents, 'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),]);

        if($sendType == "2") //In addition to send Email.
        {
            $from_email = $request->user()->email;
            $from_name = $request->user()->name;
            $to_email = Detection::find($detection_id)->user->email;
            $to_name = Detection::find($detection_id)->user->name;
            $contact_reason = session('contact_reason')[$reason];
            $data = array('title'=>'Send US A MESSAGE', 'name'=>"CYBINT ($to_name)", 'body' => $contents);
//            Mail::send('mails.contacts', $data, function($message) use ($to_name, $to_email, $from_email, $from_name) {
//                $message->to($to_email, $to_name)
//                    ->subject('Send US A MESSAGE');
//                $message->from($from_email, $from_name);
//            });
        }
        $contact_reason = session('contact_reason');
        $detections = Detection::all()->pluck('dec_id', 'id');
        $success = trans('global.msg.contact_send');
        return redirect('contacts')->with('success', trans('global.msg.contact_send'));
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
