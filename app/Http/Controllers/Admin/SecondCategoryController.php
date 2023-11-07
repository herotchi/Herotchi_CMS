<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\SecondCategory\AddRequest;

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


    public function list()
    {
        var_dump(__LINE__);
    }
}
