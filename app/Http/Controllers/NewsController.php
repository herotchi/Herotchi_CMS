<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\News;
use App\Consts\NewsConsts;
use DateTime;

class NewsController extends Controller
{
    public function list()
    {
        $model = new News();
        $lists = $model->getLists();

        return view('news.list', compact('lists'));
    }


    public function detail($id)
    {
        
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:news']
        );

        if ($validator->fails()) {
            return redirect()->route('top')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new News();
        $detail = $model->find($id);

        $errorFlg = false;
        $today = new DateTime();
        if ($detail->link_flg == NewsConsts::LINK_FLG_ON) {// リンク設定があり
            $errorFlg = true;
        } elseif ($detail->release_date->format('Y-m-d') > $today->format('Y-m-d')) {// 公開日が現在より未来
            $errorFlg = true;
        } elseif ($detail->release_flg == NewsConsts::RELEASE_FLG_OFF) {// 表示設定が非表示
            $errorFlg = true;
        }

        if ($errorFlg) {
            return redirect()->route('top')->with('msg_failure', '不正な値が入力されました。');
        }

        return view('news.detail', compact('detail'));
    }
}
