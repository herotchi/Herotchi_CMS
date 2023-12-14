<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;

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
        /*
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:news']
        );

        if ($validator->fails()) {
            return redirect()->route('top')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new News();
        $detail = $model->find($id);

        return view('news.detail', compact('detail'));*/
    }
}
