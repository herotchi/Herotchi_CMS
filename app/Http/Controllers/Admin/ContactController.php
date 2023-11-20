<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Contact\ListRequest;
use App\Http\Requests\Admin\Contact\StatusUpdateRequest;

use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

use App\Consts\ContactConsts;

class ContactController extends Controller
{
    //
    public function list(ListRequest $request)
    {
        $input = $request->validated();

        $model = new Contact();
        $lists = $model->getAdminLists($input);

        return view('admin.contact.list', compact(['lists', 'input']));
    }


    public function detail($id)
    {

        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'bail|required|integer|exists:contacts']
        );

        if ($validator->fails()) {
            return redirect()->route('admin.contact.list')->with('msg_failure', '不正な値が入力されました。');
        }

        $model = new Contact();
        $detail = $model->find($id);

        return view('admin.contact.detail', compact('detail'));
    }


    public function status_update(StatusUpdateRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data) {
            $model = new Contact();
            $model->updateContactStatus($data);
        });

        return redirect()->route('admin.contact.detail', ['id' => $data['id']])->with('msg_success', 'ステータスを更新しました。');
    }
}
