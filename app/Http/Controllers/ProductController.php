<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Product\ListRequest;

use App\Models\FirstCategory;
use App\Models\SecondCategory;
use App\Models\Product;

class ProductController extends Controller
{
    public function list(ListRequest $request)
    {
        $input = $request->validated();

        // 検索条件情報
        if ($input['first_category_id'] && $input['second_category_id']) {
            $firstCategoryModel = new FirstCategory();
            $firstCategory = $firstCategoryModel::find($input['first_category_id']);
            $secondCategory = $firstCategory->second_categories()->where('id', $input['second_category_id'])->first();
            $firstCategoryName = $firstCategory->name;
            $secondCategoryName = $secondCategory->name;
        } else {
            $firstCategoryName = null;
            $secondCategoryName = null;
        }

        $productModel = new Product();
        $products = $productModel->getLists($input);
        // 製品情報と紐づいている大カテゴリと中カテゴリのみ取得
        $firstCategoryIds = $productModel->getFirstCategoryIds();
        $secondCategoryIds = $productModel->getSecondCategoryIds();

        $firstCategories = [];
        $secondCategories = [];

        // 大カテゴリと中カテゴリの一覧を取得
        $firstCategoryModel = new FirstCategory();
        foreach ($firstCategoryModel::all() as $firstCategory) {
            $firstCategories[$firstCategory->id] = $firstCategory;
            $secondCategories[$firstCategory->id] = $firstCategory->second_categories;
        }

        return view('product.list', compact([
            'products', 
            'input', 
            'firstCategoryIds', 
            'secondCategoryIds', 
            'firstCategoryName', 
            'secondCategoryName', 
            'firstCategories', 
            'secondCategories'
        ]));
    }


    public function detail($id)
    {
        var_dump(__LINE__);
    }
}
