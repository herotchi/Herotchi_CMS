<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\SecondCategory\AddRequest;
use App\Http\Requests\Admin\SecondCategory\ListRequest;
use App\Http\Requests\Admin\SecondCategory\EditRequest;
use App\Http\Requests\Admin\SecondCategory\DeleteRequest;
use App\Http\Requests\Admin\SecondCategory\CsvImportRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\FirstCategory;
use App\Models\SecondCategory;
use App\Consts\FirstCategoryConsts;
use App\Consts\SecondCategoryConsts;

use SplFileObject;
use DateTime;

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


    public function delete(DeleteRequest $request)
    {
        DB::transaction(function () use ($request) {
            $model = new SecondCategory();
            $model->deleteSecondCategory($request->validated());
        });

        return redirect()->route('admin.second_category.list')->with('msg_success', '中カテゴリを削除しました。');
    }


    public function csv_add()
    {
        return view('admin.second_category.csv_add');
    }


    public function csv_import(CsvImportRequest $request)
    {
        $input = $request->validated();
        $today = new DateTime();
        $fileName = $today->format('YmdHis') . '.csv';

        if($request->hasFile('csv_file')) {
            if($request->csv_file->getClientOriginalExtension() !== "csv") {
                throw new Exception("拡張子が不正です。");
            }
            $request->csv_file->storeAs(SecondCategoryConsts::CSV_FILE_DIR, $fileName);
        } else {
            throw new Exception("CSVファイルの取得に失敗しました。");
        }

        $csvs = new SplFileObject(storage_path('app/'. SecondCategoryConsts::CSV_FILE_DIR . '/' . $fileName));
        $csvs->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD);

        $rules = [
            'first_category_name' => [
                'bail', 
                'required',
                'string',
                'max:' . FirstCategoryConsts::NAME_LENGTH_MAX
            ],
            'name' => [
                'bail', 
                'required',
                'string',
                'max:' . SecondCategoryConsts::NAME_LENGTH_MAX
            ],
        ];
        $attributes = [
            'first_category_name' => '大カテゴリ名',
            'name' => '中カテゴリ名',
        ];
        $errorMessages = [];
        $lines = [];

        // 大カテゴリ名存在チェック用
        $firstCategoryModel = new FirstCategory();
        $firstCategories = $firstCategoryModel::all();
        $firstCategoryNames = $firstCategories->pluck('name', 'id')->toArray();

        // 中カテゴリ名ユニークチェック用
        $secondCategoryModel = new SecondCategory();
        $secondCategories = $secondCategoryModel::all();
        $secondCategoryNames = [];
        foreach ($secondCategories as $secondCategory) {
            $secondCategoryNames[$secondCategory->first_category_id][] = $secondCategory->name;
        }

        // CSVファイル内の重複チェック用
        $inputNames = [];

        foreach ($csvs as $line => $csv) {

            // 文字コード変換
            if ($input['code'] == SecondCategoryConsts::CSV_CODE_SJIS) {
                mb_convert_variables('UTF-8','SJIS', $csv);
            }

            // ヘッダー行
            if ($line === 0) {
                if (array_values(SecondCategoryConsts::CSV_HEADER) !== $csv) {
                    $errorMessages['csv_file'][] = $line + 1 . '行目：ヘッダーの項目名が違っています。';
                }
                continue;
            }

            // 1行あたりの項目数が足りない場合
            $filteredArray = array_filter($csv, function ($value) {
                return $value !== NULL;
            });
            if (count($filteredArray) !== count(SecondCategoryConsts::CSV_HEADER)) {
                $errorMessages['csv_file'][] = $line + 1 . '行目：項目に過不足があります。';
                continue;
            }

            // バリデート用にCSVデータを整形する
            foreach (array_keys(SecondCategoryConsts::CSV_HEADER) as $key => $value) {
                $lines[$line + 1][$value] = $csv[$key];
            }

            $validator = Validator::make($lines[$line + 1], $rules, __('validation'), $attributes);

            // バリデーションエラーがあった場合
            if($validator->fails()) {
                // エラーメッセージを「xx行目：エラーメッセージ」の形に整える
                $errorMessages['csv_file'][] = $line + 1 . '行目：' . $validator->errors()->first();

            } elseif (!in_array($lines[$line + 1]['first_category_name'], $firstCategoryNames, true)) {
                // 大カテゴリが存在しない場合
                $errorMessages['csv_file'][] = $line + 1 . '行目：存在しない大カテゴリ名が入力されています。';

            } elseif (array_key_exists(array_search($lines[$line + 1]['first_category_name'], $firstCategoryNames, true), $secondCategoryNames)
            && in_array($lines[$line + 1]['name'], $secondCategoryNames[array_search($lines[$line + 1]['first_category_name'], $firstCategoryNames, true)], true)) {
                // 大カテゴリが存在する場合、それと紐づく中カテゴリも重複しているかチェックする
                $errorMessages['csv_file'][] = $line + 1 . '行目：同じ大カテゴリ内で中カテゴリ名が重複しています。';

            } elseif (array_key_exists(array_search($lines[$line + 1]['first_category_name'], $firstCategoryNames, true), $inputNames)
            && in_array($lines[$line + 1]['name'], $inputNames[array_search($lines[$line + 1]['first_category_name'], $firstCategoryNames, true)], true)) {
                // CSVファイル内に同じ大カテゴリが存在する場合、それと紐づく中カテゴリも重複しているかチェックする
                $errorMessages['csv_file'][] = $line + 1 . '行目：CSVファイル内の同じ大カテゴリ内で中カテゴリ名が重複しています。';
            } else {
                // 入力エラーがない場合
                $lines[$line + 1]['first_category_id'] = array_search($lines[$line + 1]['first_category_name'], $firstCategoryNames, true);
                $lines[$line + 1]['created_at'] = $today->format('Y-m-d H:i:s');
                $lines[$line + 1]['updated_at'] = $today->format('Y-m-d H:i:s');

                $inputNames[$lines[$line + 1]['first_category_id']][] = $lines[$line + 1]['name'];
            }

            // 不要な配列の要素を削除する
            unset($lines[$line + 1]['first_category_name']);
        }
        
        // CSVファイル内で入力エラーがあった場合
        if (count($errorMessages) > 0) {
            $csvs = null;
            Storage::delete(SecondCategoryConsts::CSV_FILE_DIR . '/' . $fileName);

            return redirect()->route('admin.second_category.csv_add')->withErrors($errorMessages)->withInput();
        }

        DB::transaction(function () use ($lines) {
            DB::table('second_categories')->insert($lines);
        });

        $csvs = null;
        Storage::delete(SecondCategoryConsts::CSV_FILE_DIR . '/' . $fileName);

        return redirect()->route('admin.second_category.list')->with('msg_success', '中カテゴリを登録しました。');
    }
}