<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Detection;
use App\Models\Tags;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\User;
use Mail;
use phpDocumentor\Reflection\DocBlock\Tag;

class ReportsController extends Controller
{
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
            $detections =  Detection::where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
            return view('pages.reports.index', compact('detections'));
        }
        $detections = Detection::all();
        return view('pages.reports.index', compact('detections'));
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
     * Report export.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function csvExport(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'multi_select' => 'required|array',
            ]);

            if ($validator->fails()) {
                $error_messages = $validator->errors()->messages();
                return new JsonResponse($error_messages, 400);
            }
            $settings = $request->multi_select;
            array_unshift($settings,"id");

            $detections = [];
            if(Auth::user()->hasRole('client'))
            {
                $curUserId = Auth::user()->id;
                $detections =  Detection::query()->where('detections.client_send_ids', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->select($settings)->get();
            } else
            {
                $detections = Detection::query()->select($settings)->get();
            }
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=file.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );
            $cols['id'] = trans('cruds.detections.fields.id');
            $cols['dec_id'] = trans('cruds.detections.fields.dec_id');
            $cols['title']  = trans('cruds.detections.fields.title');
            $cols['type'] = trans('cruds.detections.fields.detection_type');
            $cols['emergency'] = trans('cruds.detections.fields.emergency');
            $cols['detection_level'] = trans('cruds.detections.fields.detection_level');
            $cols['tlp'] = trans('cruds.detections.fields.tlp');
            $cols['pap'] = trans('cruds.detections.fields.pap');
            $cols['tags'] = trans('cruds.detections.fields.tags_detection');
            $cols['comment'] = trans('cruds.detections.fields.analyst_comments');
            $cols['description'] = trans('cruds.detections.fields.description');
            $cols['scenery'] = trans('cruds.detections.fields.threat_scenery');
            $cols['tech_detail'] = trans('cruds.detections.fields.tech_details');
            $cols['reference'] = trans('cruds.detections.fields.reference_url');
            $cols['evidence'] = trans('cruds.detections.fields.evidences');
            $cols['ioc'] = trans('cruds.detections.fields.ioc');
            $cols['cves'] = trans('cruds.detections.fields.cves');
            $cols['cvss'] = trans('cruds.detections.fields.cvss');
            $cols['created_at'] = trans('cruds.detections.fields.created_date');

            $columns = [];
            foreach ($settings as $val)
            {
                $columns[] = $cols[$val];
            }

            $callback = function() use ($detections, $settings, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach($detections as $row) {
                    $csvVal = [];
                    foreach ($settings as $col) {
                        if($col == 'tags')
                        {
                            if(!is_null($row[$col]))
                            {
                                $tags = unserialize($row[$col]);
                            }
                            $tagsStr = '';
                            foreach ($tags as $id)
                            {
                                $tagsStr .= Tags::find($id)->tag . ", ";
                            }
                            $csvVal[] = substr($tagsStr, 0,-2);
                        } else if($col == 'reference' || $col == 'cves')
                        {
                            if(!is_null($row[$col]) &&  $row[$col] != "" && !empty($row[$col]))
                            {
                                $vallist = json_decode($row[$col]);
                                $strVal = '';
                                foreach ($vallist as $val)
                                {
                                    $strVal .= $val->value . ", ";
                                }
                                $csvVal[] = substr($strVal, 0,-2);
                            } else
                            {
                                $csvVal[] = '';
                            }
                        } else if($col == 'evidence')
                        {
                            if(!is_null($row[$col]) &&  $row[$col] != "" && !empty($row[$col]))
                            {
                                $strVal = '';
                                $vals = unserialize($row[$col]);
                                foreach ($vals as $val)
                                {
                                    $strVal .= $val . ", ";
                                }
                                $csvVal[] = substr($strVal, 0,-2);
                            } else
                            {
                                $csvVal[] = '';
                            }
                        } else if($col == 'ioc')
                        {
                            if(!is_null($row[$col]) &&  $row[$col] != "" && !empty($row[$col]))
                            {
                                $strVal = '';
                                $vals = unserialize($row[$col]);
                                foreach ($vals as $key => $val)
                                {
                                    $strVal .= session('ioc')[$key] . ':' . $val . ", ";
                                }
                                $csvVal[] = substr($strVal, 0,-2);
                            } else
                            {
                                $csvVal[] = '';
                            }
                        }
                        else if($col == 'created_at')
                        {
                            $created_date = (array) $row[$col];
                            $csvVal[] = $created_date['date'];
                        } else if($col == 'type')
                        {
                            $csvVal[] = session('dec_type')[$row[$col]];
                        } else if($col == 'emergency')
                        {
                            $csvVal[] = session('emergency')[$row[$col]];
                        } else if($col == 'detection_level')
                        {
                            $csvVal[] = session('dec_level')[$row[$col]];
                        } else if($col == 'tlp')
                        {
                            $csvVal[] = session('tlp')[$row[$col]];
                        } else if($col == 'pap')
                        {
                            $csvVal[] = session('pap')[$row[$col]];
                        } else if($col == 'cvss')
                        {
                            if(!is_null($row[$col]))
                            {
                                $csvVal[] = session('cvss')[$row[$col]];
                            } else
                            {
                                $csvVal[] = '';
                            }
                        }
                        else
                        {
                            $csvVal[] = $row[$col] ?? '';
                        }
                    }
                    fputcsv($file, $csvVal);
                }
                fclose($file);
            };
            return response()->streamDownload($callback, 'output.csv');
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
