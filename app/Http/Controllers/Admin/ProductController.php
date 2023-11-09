<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Product\AddRequest;
use App\Http\Requests\Admin\Product\ListRequest;
//use App\Http\Requests\Admin\Product\EditRequest;
//use App\Http\Requests\Admin\Product\DeleteRequest;

use Illuminate\Support\Facades\DB;
use App\Models\FirstCategory;
use App\Models\SecondCategory;
use App\Models\Product;
use App\Models\News;

use App\Consts\ProductConsts;

class ProductController extends Controller
{
    //
    public function add()
    {
        $firstCategoryModel = new FirstCategory();
        $firstCategories = $firstCategoryModel->getLists();

        $secondCategoryModel = new SecondCategory();
        $secondCategories = $secondCategoryModel->getLists();

        return view('admin.product.add', compact(['firstCategories', 'secondCategories']));
    }


    public function insert(AddRequest $request)
    {
        DB::transaction(function () use ($request) {
            $image = $request->file('image');
            $fileName = $image->hashName();
            $dir = ProductConsts::IMAGE_FILE_DIR;
            $image->storeAs('public/' . $dir, $fileName);
            $productModel = new Product();
            $productId = $productModel->insertProduct($request->validated(), $fileName, $dir);
            $newsModel = new News();
            $newsModel->insertProductNews($productId);
        });

        return redirect()->route('admin.product.list')->with('msg_success', '製品を登録しました。');
    }


    public function list(ListRequest $request)
    {
        $input = $request->validated();

        $firstCategoryModel = new FirstCategory();
        $firstCategories = $firstCategoryModel->getLists();

        $secondCategoryModel = new SecondCategory();
        $secondCategories = $secondCategoryModel->getLists();

        $productModel = new Product();
        $lists = $productModel->getAdminLists($input);

        return view('admin.product.list', compact(['firstCategories', 'secondCategories', 'lists', 'input']));
    }


    public function detail($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:products']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.product.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new Product();
        $detail = $model->find($id);

        return view('admin.product.detail', compact('detail'));
    }


    public function edit()
    {
        var_dump(__LINE__);
    }


    public function update()
    {
        var_dump(__LINE__);
    }


    public function delete()
    {
        var_dump(__LINE__);
    }
}
