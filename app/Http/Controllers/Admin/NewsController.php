<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\News\AddRequest;
use App\Http\Requests\Admin\News\ListRequest;
use App\Http\Requests\Admin\News\EditRequest;
use App\Http\Requests\Admin\News\DeleteRequest;

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
        $lists = $model->getAdminLists($input);

        return view('admin.news.list', compact(['lists', 'input']));
    }


    public function detail($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:news']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.news.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new News();
        $detail = $model->find($id);

        return view('admin.news.detail', compact('detail'));
    }


    public function edit($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:news']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.news.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new News();
        $detail = $model->find($id);

        return view('admin.news.edit', compact('detail'));
    }


    public function update(EditRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new News();
            $model->updateNews($request->validated());
        });

        return redirect()->route('admin.news.list')->with('msg_success', 'お知らせを編集しました。');
    }


    public function delete(DeleteRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new News();
            $model->deleteNews($request->validated());
        });

        return redirect()->route('admin.news.list')->with('msg_success', 'お知らせを削除しました。');
    }
}
