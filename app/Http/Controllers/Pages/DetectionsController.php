<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Detection;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\User;

use App\Models\Tags;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;

class DetectionsController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('client'))
        {
            $curUserId = Auth::user()->id;
            //$detections = Detection::query()->where('client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
            //$detections = $decModel->where('client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
            $decList =  Detection::where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
//                leftJoin('dec_attachments', 'detections.id', '=', 'dec_attachments.parent_id')->select('detections.id', 'detections.dec_id', 'detections.title', 'detections.description',
//                'detections.detection_level', 'detections.created_at', 'detections.type', 'dec_attachments.mark_read', 'dec_attachments.feedback')->get();
            $detections = [];
            foreach ($decList as $row)
            {
                $res = $row->dec_attachment()->where('client_id', $curUserId)->get();
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
            return view('pages.detections.index_client', compact('detections'));
        }
        $detections = Detection::all();
        return view('pages.detections.index', compact('detections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->put('attach_files', []);
        $emergency = session()->get('emergency');
        $dec_type = session('dec_type');
        $dec_level = session('dec_level');
        $tlp = session('tlp');
        $pap = session('pap');
        $ioc = session('ioc');
        $cvss = session('cvss');
        $tag_group = ['Global', 'NIST', 'MITER Att & Ck'];

        $tags = [];

        $tag_list = Tags::query()->orderBy('group')->groupBy('group')->select( 'group', \DB::raw("GROUP_CONCAT(id, '::', tag) as tags"))->get();

        foreach ($tag_list as $row)
        {
            $childs = explode(",", $row->tags);
            $tagMap = [];
            foreach ($childs as $child)
            {
                $id = explode("::", $child)[0];
                $tag = explode("::", $child)[1];
                $tagMap[$id] = $tag;
            }
            $tags[$tag_group[$row->group]] = $tagMap;
        }

        $clients = User::whereHas('roles', function($role) {
            $role->where('name', '=', 'client');
        })->pluck('name', 'id');

        return view('pages.detections.create', compact('tags','clients', 'emergency', 'dec_type',
            'dec_level', 'tlp', 'pap', 'ioc', 'tlp', 'cvss'));
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
                'title' => 'required',
                'clients' => 'required',
                'tags'  => 'required'
            ]
        );
        // Build Insert Parameter.
        $insertData = [];
        $insertData['user_id'] = $request->user()->id;
        $insertData['dec_id'] = date('Y-m-d').'-'.$this->generateRandomString(4);
        $insertData['title'] = $request->title;
        $insertData['type'] = $request->type;
        $insertData['emergency'] = $request->emergency;
        $insertData['detection_level'] = $request->level;
        $insertData['tlp'] = $request->tlp;
        $insertData['pap'] = $request->pap;
        $insertData['client_send_ids'] = serialize($request->clients);
        $insertData['tags'] = serialize($request->tags);
        $insertData['comment'] = $request->comment;
        $insertData['description'] = $request->description;
        $insertData['scenery'] = $request->scenery;
        $insertData['tech_detail'] = $request->tech_detail;
        $insertData['reference'] = $request->references;
        if(sizeof(session('attach_files')) > 0)
        {
            $insertData['evidence'] = serialize(session('attach_files'));
        }
        if(isset($request->ioc_type) && sizeof($request->ioc_type) > 0)
        {
            $iocLst = [];
            foreach ($request->ioc_type as $key => $item) {
                $iocLst[$item] = $request->ioc_value[$key];
            }
            $insertData['ioc'] = serialize($iocLst);
        }
        if($insertData['type'] == 2)
        {
            $insertData['cves'] = $request->cves;
            if(!isset($request->cvss))
                $insertData['cvss'] = 0;
            else
                $insertData['cvss'] = $request->cvss;
        }
        $res = Detection::create($insertData);

        $notifyData['creater_id'] = $request->user()->id;
        $notifyData['detection_id'] = $res->id;
        $notifyData['detection_type'] = $request->type;
        $notifyData['send_clients'] = serialize($request->clients);
        $notifyData['seen_users'] = serialize([]);
        Notification::create($notifyData);
        return redirect()->route('detections.index');
    }

    /**
     * Random string generator.
     *
     * @param  Interger  $length
     * @return String
     */
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtoupper($randomString);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxUploadFile(Request $request)
    {
        if(request()->ajax()) {
            $ret = [];
            if (isset($_FILES["myfile"])) {

                //	This is for custom errors;
                /*	$custom_error= array();
                    $custom_error['jquery-upload-file-error']="File already exists";
                    echo json_encode($custom_error);
                    die();
                */
                $error = $_FILES["myfile"]["error"];
                //You need to handle  both cases
                //If Any browser does not support serializing of multiple files using FormData()
                if (!is_array($_FILES["myfile"]["name"])) //single file
                {
                    $fileName = $_FILES["myfile"]["name"];
                    Storage::disk('local')->put('public/upload/files' . '/' . $fileName, file_get_contents($_FILES["myfile"]["tmp_name"]), 'public');
                    $ret[] = $fileName;
                } else  //Multiple files, file[]
                {
                    $fileCount = count($_FILES["myfile"]["name"]);
                    for ($i = 0; $i < $fileCount; $i++) {
                        $fileName = $_FILES["myfile"]["name"][$i];

                        Storage::disk('local')->put('public/upload/files' . '/' . $fileName, file_get_contents($_FILES["myfile"]["tmp_name"][$i]), 'public');
                        $ret[] = $fileName;
                    }
                }
                $curFileList = session('attach_files');
                if (($key = array_search($fileName, $curFileList)) === false) {
                    array_push($curFileList, $fileName);
                    session()->put('attach_files', $curFileList);
                }
                return new JsonResponse($ret);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxDeleteFile(Request $request)
    {
        if(request()->ajax()) {
            if(isset($request->op) && $request->op == "delete" && isset($request->name))
            {
                $fileName =$request->name;
                $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
                Storage::delete("upload/files/".$fileName);
                $curFileLst = session('attach_files');
                if (($key = array_search($fileName, $curFileLst)) !== false) {
                    unset($curFileLst[$key]);
                }
                session()->put('attach_files', $curFileLst);
                if(isset($request->id))
                {
                    $curFileLst = unserialize(Detection::find($request->id)->evidence);
                    if (($key = array_search($fileName, $curFileLst)) !== false) {
                        unset($curFileLst[$key]);
                    }
                    Detection::find($request->id)->update(['evidence' => serialize($curFileLst)]);
                }
                return new JsonResponse($curFileLst);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxLoadFile(Request $request)
    {
        if(request()->ajax()) {
            $dir = asset('storage/upload/files');
            $dec_id = $request->id;
            $evidence = unserialize(Detection::find($dec_id)->evidence) ?? [];
            $ret = [];
            if(is_array($evidence))
            {
                foreach ($evidence as $file) {
                    if ($file == "." || $file == "..")
                        continue;
                    $filePath = $dir . "/" . $file;
                    $details = array();
                    $details['name'] = $file;
                    $details['path'] = $filePath;
                    //$details['size'] = $this->getFileSize($filePath);
                    $details['size'] = rand(1000,9999999);
                    $ret[] = $details;
                }
                return new JsonResponse($ret);
            }
        }
    }

    /**
     * Get url file size processor.
     *
     * @param  String $url
     * @return Integer
     */
    public function getFileSize($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);

        $data = curl_exec($ch);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        curl_close($ch);
        return $size;
    }

    /**
     * Ajax mark read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detection $detection
     * @return \Illuminate\Http\Response
     */
    public function ajaxMarkRead(Request $request, Detection $detection)
    {
        if(request()->ajax()) {
            if(isset($request->mark_read))
            {
                $markRead = $request->mark_read;
                $client_id = $request->user()->id;
                $dec_id = $detection->id;
                $markRead == 'false' ? $markRead = 0 : $markRead = 1;
                $detection->dec_attachment()->updateOrInsert(['client_id' => $client_id], ['parent_id' => $dec_id, 'mark_read' => $markRead])->touch();
                return new JsonResponse([], 200);
            }
        }
    }

    /**
     * Ajax send feedback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detection $detection
     * @return \Illuminate\Http\Response
     */
    public function ajaxSendFeedback(Request $request, Detection $detection)
    {
        if(request()->ajax()) {
            if(isset($request->feedback))
            {
                $validator = Validator::make($request->all(), [
                    'feedback' => 'required|min:10|max:500',
                ]);

                if ($validator->fails()) {
                    $error_messages = $validator->errors()->messages();
                    return new JsonResponse($error_messages, 400);
                }
                $feedback = $request->feedback;
                $client_id = $request->user()->id;
                $dec_id = $detection->id;
                $detection->dec_attachment()->updateOrInsert(['client_id' => $client_id], ['parent_id' => $dec_id, 'feedback' => $feedback])->touch();
                return new JsonResponse([], 200);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downLoadFile(Request $request)
    {
        if(isset($request->filename))
        {
            $fileName=$request->filename;
            $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent
            return response()->download(storage_path("app/public/upload/files/{$fileName}"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detection  $detection
     * @return \Illuminate\Http\Response
     */
    public function show(Detection $detection)
    {
        $emergency = session()->get('emergency');
        $dec_type = session('dec_type');
        $dec_level = session('dec_level');
        $tlp = session('tlp');
        $pap = session('pap');
        $ioc = session('ioc');
        $cvss = session('cvss');
        $tag_group = ['Global', 'NIST', 'MITER Att & Ck'];

        $tags = [];

        $tag_list = Tags::query()->orderBy('group')->groupBy('group')->select( 'group', \DB::raw("GROUP_CONCAT(id, '::', tag) as tags"))->get();

        foreach ($tag_list as $row)
        {
            $childs = explode(",", $row->tags);
            $tagMap = [];
            foreach ($childs as $child)
            {
                $id = explode("::", $child)[0];
                $tag = explode("::", $child)[1];
                $tagMap[$id] = $tag;
            }
            $tags[$tag_group[$row->group]] = $tagMap;
        }

        $clients = User::whereHas('roles', function($role) {
            $role->where('name', '=', 'client');
        })->pluck('name', 'id');
        if(is_array(unserialize($detection->evidence)))
            session()->put('attach_files', unserialize($detection->evidence));
        else
            session()->put('attach_files', []);
        return view('pages.detections.show', compact('detection', 'tags', 'clients', 'emergency', 'dec_type',
            'dec_level', 'tlp', 'pap', 'ioc', 'tlp', 'cvss'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detection  $detection
     * @return \Illuminate\Http\Response
     */
    public function edit(Detection $detection)
    {
        //Notification add seens user



        if(Auth::user()->hasRole('client'))
            return redirect(route('detections.show', $detection->id));
        else if(Auth::user()->hasRole('analyst') && $detection->user_id != Auth::user()->id)
        {
            return redirect(route('detections.show', $detection->id));
        }

        $emergency = session()->get('emergency');
        $dec_type = session('dec_type');
        $dec_level = session('dec_level');
        $tlp = session('tlp');
        $pap = session('pap');
        $ioc = session('ioc');
        $cvss = session('cvss');
        $tag_group = ['Global', 'NIST', 'MITER Att & Ck'];

        $tags = [];

        $tag_list = Tags::query()->orderBy('group')->groupBy('group')->select( 'group', \DB::raw("GROUP_CONCAT(id, '::', tag) as tags"))->get();

        foreach ($tag_list as $row)
        {
            $childs = explode(",", $row->tags);
            $tagMap = [];
            foreach ($childs as $child)
            {
                $id = explode("::", $child)[0];
                $tag = explode("::", $child)[1];
                $tagMap[$id] = $tag;
            }
            $tags[$tag_group[$row->group]] = $tagMap;
        }

        $clients = User::whereHas('roles', function($role) {
            $role->where('name', '=', 'client');
        })->pluck('name', 'id');
        if(is_array(unserialize($detection->evidence)))
            session()->put('attach_files', unserialize($detection->evidence));
        else
            session()->put('attach_files', []);
        return view('pages.detections.edit', compact('detection', 'tags', 'clients', 'emergency', 'dec_type',
            'dec_level', 'tlp', 'pap', 'ioc', 'tlp', 'cvss'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detection $detection)
    {

        $request->validate(
            [
                'title' => 'required',
                'clients' => 'required|array',
                'tags'  => 'required|array'
            ]
        );
        // Build Insert Parameter.
        $updateData = [];
        $updateData['user_id'] = $request->user()->id;
        $updateData['title'] = $request->title;
        $updateData['type'] = $request->type;
        $updateData['emergency'] = $request->emergency;
        $updateData['detection_level'] = $request->level;
        $updateData['tlp'] = $request->tlp;
        $updateData['pap'] = $request->pap;
        $updateData['client_send_ids'] = serialize($request->clients);
        $updateData['tags'] = serialize($request->tags);
        $updateData['comment'] = $request->comment;
        $updateData['description'] = $request->description;
        $updateData['scenery'] = $request->scenery;
        $updateData['tech_detail'] = $request->tech_detail;
        $updateData['reference'] = $request->references;
        if(sizeof(session('attach_files')) > 0)
        {
            $updateData['evidence'] = serialize(session('attach_files'));
        } else
        {
            $updateData['evidence'] = null;
        }
        if(isset($request->ioc_type) && sizeof($request->ioc_type) > 0)
        {
            $iocLst = [];
            foreach ($request->ioc_type as $key => $item) {
                $iocLst[$item] = $request->ioc_value[$key];
            }
            $updateData['ioc'] = serialize($iocLst);
        } else
        {
            $updateData['ioc'] = null;
        }
        if($updateData['type'] == 2)
        {
            $updateData['cves'] = $request->cves;
            if(!isset($request->cvss))
                $updateData['cvss'] = 0;
            else
                $updateData['cvss'] = $request->cvss;
        } else
        {
            $updateData['cvss'] = null;
            $updateData['cves'] = null;
        }
        $detection->update($updateData);

        return redirect()->route('detections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detection $detection)
    {
        if(!is_null($detection->evidence) && !empty($detection->evidence))
        {
            $fileLst = unserialize($detection->evidence);
            foreach ($fileLst as $file)
            {
                Storage::delete("upload/files/".$file);
            }
        }
        $detection->delete();
        return redirect()->route('detections.index');
    }
}
