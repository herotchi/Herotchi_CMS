<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function list()
    {
        var_dump(__LINE__);
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
