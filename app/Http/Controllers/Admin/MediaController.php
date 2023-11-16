<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Media\AddRequest;
use App\Http\Requests\Admin\Media\ListRequest;
use App\Http\Requests\Admin\Media\EditRequest;
//use App\Http\Requests\Admin\Media\DeleteRequest;

use Illuminate\Support\Facades\DB;
use App\Models\Media;

use App\Consts\MediaConsts;

class MediaController extends Controller
{
    //
    public function add()
    {
        return view('admin.media.add');
    }
    
    public function insert(AddRequest $request)
    {
        DB::transaction(function () use ($request) {
            $image = $request->file('image');
            $fileName = $image->hashName();
            $image->storeAs('public/' . MediaConsts::IMAGE_FILE_DIR, $fileName);
            $model = new Media();
            $model->insertMedia($request->validated(), $fileName);
        });

        return redirect()->route('admin.media.list')->with('msg_success', '製品を登録しました。');
    }


    public function list(ListRequest $request)
    {
        $input = $request->validated();

        $model = new Media();
        $lists = $model->getAdminLists($input);

        return view('admin.media.list', compact(['lists', 'input']));
    }


    public function detail($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:media']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.media.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new Media();
        $detail = $model->find($id);

        return view('admin.media.detail', compact('detail'));
    }


    public function edit($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:media']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.media.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new Media();
        $detail = $model->find($id);

        return view('admin.media.edit', compact('detail'));
    }


    public function update(EditRequest $request)
    {
        DB::transaction(function () use ($request) {
            
            $image = $request->file('image');
            if ($image) {
                $fileName = $image->hashName();
                $image->storeAs('public/' . MediaConsts::IMAGE_FILE_DIR, $fileName);
            } else {
                $fileName = '';
            }

            $model = new Media();
            $model->updateMedia($request->validated(), $fileName);
        });

        return redirect()->route('admin.media.list')->with('msg_success', 'メディアを編集しました。');
    }


    public function delete()
    {
        var_dump(__LINE__);
    }
}
