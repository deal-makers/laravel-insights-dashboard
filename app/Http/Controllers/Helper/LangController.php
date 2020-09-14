<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Lang;

use App\User;


class LangController extends Controller
{
    /**
     * Chage language setting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxChangeLang(Request $request)
    {
        if(request()->ajax()) {
            $user_id = $request->user()->id;
            $cur_lang = $request->lang;

            Lang::query()->updateOrInsert(
                ['user_id' => $user_id],
                ['user_id' => $user_id, 'lang' => $cur_lang, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

            session()->put('cur_lang', $cur_lang);

            $availLocale = session()->get('avail_locale');

            return new JsonResponse([], 200);
        }
    }
}
