<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\SecondCategory\AddRequest;
use App\Http\Requests\Admin\SecondCategory\ListRequest;
use App\Http\Requests\Admin\SecondCategory\EditRequest;

use Illuminate\Support\Facades\DB;
use App\Models\FirstCategory;
use App\Models\SecondCategory;

class SecondCategoryController extends Controller
{
    //
    public function add()
    {
        $model = new FirstCategory();
        $firstCategories = $model->getLists();

        return view('admin.second_category.add', compact('firstCategories'));
    }


    public function insert(AddRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new SecondCategory();
            $model->insertSecondCategory($request->validated());
        });

        return redirect()->route('admin.second_category.list')->with('msg_success', '中カテゴリを登録しました。');
    }


    public function list(ListRequest $request)
    {
        $input = $request->validated();

        $firstCategoryModel = new FirstCategory();
        $firstCategories = $firstCategoryModel->getLists();

        $secondCategoryModel = new SecondCategory();
        $lists = $secondCategoryModel->getAdminLists($input);

        return view('admin.second_category.list', compact(['firstCategories', 'lists', 'input']));
    }


    public function detail($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:second_categories']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.second_category.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new SecondCategory();
        $detail = $model->find($id);

        return view('admin.second_category.detail', compact('detail'));
    }


    public function edit($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:second_categories']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.second_category.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $firstCategoryModel = new FirstCategory();
        $firstCategories = $firstCategoryModel->getLists();

        $secondCategoryModel = new SecondCategory();
        $detail = $secondCategoryModel->find($id);

        return view('admin.second_category.edit', compact(['detail', 'firstCategories']));
    }


    public function update(EditRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new SecondCategory();
            $model->updateSecondCategory($request->validated());
        });

        return redirect()->route('admin.second_category.list')->with('msg_success', '中カテゴリを編集しました。');
    }


    public function delete()
    {
        var_dump(__LINE__);
    }
}