<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tags::all();

        return view('pages.tags.index', compact('tags'));

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
        $request->request->add(['user_id' => $request->user()->id]);
        $validator = Validator::make($request->all(), [
            'group' => 'required|integer',
            'tag' => 'required|unique:tags',
        ]);

        if ($validator->fails()) {
            $error_messages = $validator->errors()->messages();
            return new JsonResponse($error_messages, 400);
        }
        $res = Tags::create($request->all());
        return new JsonResponse($res);
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
    public function update(Request $request, Tags $tag)
    {
        if(request()->ajax())
        {
            $request->request->add(['user_id' => $request->user()->id]);
            $validator = Validator::make($request->all(), [
                'group' => 'required|integer',
                'tag' => 'required|unique:tags',
            ]);

            if ($validator->fails()) {
                $error_messages = $validator->errors()->messages();
                return new JsonResponse($error_messages, 400);
            }
            $res = $tag->update($request->all());
            return new JsonResponse($res);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index');   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxUpdate(Request $request, Tags $tag)
    {
        if(request()->ajax()) {
            $request->request->add(['user_id' => $request->user()->id]);
            if($request->change_flag == 1)
            {
                $validator = Validator::make($request->all(), [
                    'group' => 'required|integer',
                    'tag' => 'required|unique:tags',
                ]); 
            } else
            {
                $validator = Validator::make($request->all(), [
                    'group' => 'required|integer',
                    'tag' => 'required',
                ]);
            }
            if ($validator->fails()) {
                $error_messages = $validator->errors()->messages();
                return new JsonResponse($error_messages, 400);
            }
            $res = $tag->update($request->all());
            return new JsonResponse($res);
        }
    }
}
