<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Product\AddRequest;
use App\Http\Requests\Admin\Product\ListRequest;
use App\Http\Requests\Admin\Product\EditRequest;
use App\Http\Requests\Admin\Product\DeleteRequest;

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
            $image->storeAs('public/' . ProductConsts::IMAGE_FILE_DIR, $fileName);
            $productModel = new Product();
            $productId = $productModel->insertProduct($request->validated(), $fileName);
            $newsModel = new News();
            $newsModel->saveProductNews($productId, ProductConsts::PRODUCT_NEWS_INSERT_MESSAGE);
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


    public function edit($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:products']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.product.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $firstCategoryModel = new FirstCategory();
        $firstCategories = $firstCategoryModel->getLists();

        $secondCategoryModel = new SecondCategory();
        $secondCategories = $secondCategoryModel->getLists();

        $productModel = new Product();
        $detail = $productModel->find($id);

        return view('admin.product.edit', compact(['detail', 'firstCategories', 'secondCategories']));
    }


    public function update(EditRequest $request)
    {
        DB::transaction(function () use ($request) {
            
            $image = $request->file('image');
            if ($image) {
                $fileName = $image->hashName();
                $image->storeAs('public/' . ProductConsts::IMAGE_FILE_DIR, $fileName);
            } else {
                $fileName = '';
            }

            $productModel = new Product();
            $productId = $productModel->updateProduct($request->validated(), $fileName);
            $newsModel = new News();
            $newsModel->saveProductNews($productId, ProductConsts::PRODUCT_NEWS_UPDATE_MESSAGE);
        });

        return redirect()->route('admin.product.list')->with('msg_success', '製品を編集しました。');
    }


    public function delete(DeleteRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new Product();
            $model->deleteProduct($request->validated());
        });

        return redirect()->route('admin.product.list')->with('msg_success', '製品を削除しました。');
    }
}
