<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\News\AddRequest;
use App\Http\Requests\Admin\News\ListRequest;

use Illuminate\Support\Facades\DB;
use App\Models\News;


class NewsController extends Controller
{
    //
    public function add()
    {
        return view('admin.news.add');
    }


    public function insert(AddRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new News();
            $model->insertNews($request->validated());
        });

        return redirect()->route('admin.news.list')->with('msg_success', 'お知らせを登録しました。');
    }


    public function list(ListRequest $request)
    {
        $input = $request->validated();
        $model = new News();
        $lists = $model->getAdminList($input);

        return view('admin.news.list', compact(['lists', 'input']));
    }


    public function detail($id)
    {

    }

}
