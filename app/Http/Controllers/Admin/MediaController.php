<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Media\AddRequest;
//use App\Http\Requests\Admin\Media\ListRequest;
//use App\Http\Requests\Admin\Media\EditRequest;
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


    public function list()
    {
        var_dump(__LINE__);
    }
}
