<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Contact\ListRequest;

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


    public function detail()
    {
        var_dump(__LINE__);
    }
}
