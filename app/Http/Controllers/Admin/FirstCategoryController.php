<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\FirstCategory\AddRequest;
use App\Http\Requests\Admin\FirstCategory\ListRequest;

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
        $lists = $model->getAdminList($input);

        return view('admin.first_category.list', compact(['lists', 'input']));
    }


    public function edit()
    {
        
    }
}
