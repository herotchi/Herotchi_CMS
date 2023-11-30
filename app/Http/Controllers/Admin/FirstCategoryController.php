<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\FirstCategory\AddRequest;
use App\Http\Requests\Admin\FirstCategory\ListRequest;
use App\Http\Requests\Admin\FirstCategory\EditRequest;
use App\Http\Requests\Admin\FirstCategory\DeleteRequest;
use App\Http\Requests\Admin\FirstCategory\CsvImportRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\FirstCategory;
use App\Consts\FirstCategoryConsts;

use SplFileObject;
use DateTime;

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


    public function csv_add()
    {
        return view('admin.first_category.csv_add');
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
            $request->csv_file->storeAs(FirstCategoryConsts::CSV_FILE_DIR, $fileName);
        } else {
            throw new Exception("CSVファイルの取得に失敗しました。");
        }

        $csvs = new SplFileObject(storage_path('app/'. FirstCategoryConsts::CSV_FILE_DIR . '/' . $fileName));

        //$csv->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE);
        $csvs->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD);

        $rules = [
            'name' => [
                'bail', 
                'required',
                'string',
                'max:' . FirstCategoryConsts::NAME_LENGTH_MAX
            ]
        ];
        $attributes = [
            'name' => '大カテゴリ名',
        ];
        $errorMessages = [];
        $lines = [];

        // 大カテゴリ名ユニークチェック用
        $model = new FirstCategory();
        $firstCategories = $model::all();
        $names = $firstCategories->pluck('name')->toArray();

        foreach ($csvs as $line => $csv) {

            // 文字コード変換
            if ($input['code'] == FirstCategoryConsts::CSV_CODE_SJIS) {
                mb_convert_variables('UTF-8','SJIS', $csv);
            }

            // ヘッダー行
            if ($line === 0) {
                if (array_values(FirstCategoryConsts::CSV_HEADER) !== $csv) {
                    $errorMessages['csv_file'][] = $line + 1 . '行目：ヘッダーの項目名が違っています';
                }
                continue;
            }

            foreach (FirstCategoryConsts::CSV_HEADER as $key => $value) {
                $lines[$line + 1][$key] = $csv[0];
            }

            $validator = Validator::make($lines[$line + 1], $rules, __('validation'), $attributes);
    
            // バリデーションエラーがあった場合
            if($validator->fails()) {
                // エラーメッセージを「xx行目：エラーメッセージ」の形に整える
                $errorMessages['csv_file'][] = $line + 1 . '行目：' . $validator->errors()->first();
            } elseif (in_array($lines[$line + 1]['name'], $names, true)) {
                $errorMessages['csv_file'][] = $line + 1 . '行目：既に存在する大カテゴリ名と重複しています';
            } else {
                $lines[$line + 1]['created_at'] = $today->format('Y-m-d H:i:s');
                $lines[$line + 1]['updated_at'] = $today->format('Y-m-d H:i:s');
            }
        }

        // CSVファイル内で入力エラーがあった場合
        if (count($errorMessages) > 0) {
            $csvs = null;
            Storage::delete(FirstCategoryConsts::CSV_FILE_DIR . '/' . $fileName);

            return redirect()->route('admin.first_category.csv_add')->withErrors($errorMessages)->withInput();
        }

        DB::transaction(function () use ($lines) {
            DB::table('first_categories')->insert($lines);
        });

        $csvs = null;
        Storage::delete(FirstCategoryConsts::CSV_FILE_DIR . '/' . $fileName);

        return redirect()->route('admin.first_category.list')->with('msg_success', '大カテゴリを登録しました。');
    }
}
