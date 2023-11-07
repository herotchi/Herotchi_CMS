<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\FirstCategory\AddRequest;
use App\Http\Requests\Admin\FirstCategory\ListRequest;
use App\Http\Requests\Admin\FirstCategory\EditRequest;
use App\Http\Requests\Admin\FirstCategory\DeleteRequest;

use Illuminate\Support\Facades\DB;
use App\Models\FirstCategory;

class FirstCategoryController extends Controller
{
    //
    public function add()
    {
        return view('admin.first_category.add');
    }


    public function insert(AddRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new FirstCategory();
            $model->insertFirstCategory($request->validated());
        });

        return redirect()->route('admin.first_category.list')->with('msg_success', '大カテゴリを登録しました。');
    }


    public function list(ListRequest $request)
    {
        $input = $request->validated();
        $model = new FirstCategory();
        $lists = $model->getAdminLists($input);

        return view('admin.first_category.list', compact(['lists', 'input']));
    }


    public function detail($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:first_categories']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.first_category.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new FirstCategory();
        $detail = $model->find($id);

        return view('admin.first_category.detail', compact('detail'));
    }


    public function edit($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:first_categories']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.first_category.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new FirstCategory();
        $detail = $model->find($id);

        return view('admin.first_category.edit', compact('detail'));
    }


    public function update(EditRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new FirstCategory();
            $model->updateFirstCategory($request->validated());
        });

        return redirect()->route('admin.first_category.list')->with('msg_success', '大カテゴリを編集しました。');
    }


    public function delete(DeleteRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new FirstCategory();
            $model->deleteFirstCategory($request->validated());
        });

        return redirect()->route('admin.first_category.list')->with('msg_success', '大カテゴリを削除しました。');
    }
}
