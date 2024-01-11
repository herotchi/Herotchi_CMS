<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Contact\AddRequest;
use App\Http\Requests\Contact\ConfirmRequest;

use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

use App\Consts\ContactConsts;

class ContactController extends Controller
{
    //
    public function add()
    {
        return view('contact.add');
    }


    public function confirm(AddRequest $request)
    {
        $input = $request->validated();
        $request->session()->put('input', $input);

        return view('contact.confirm', compact('input'));
    }


    public function insert(ConfirmRequest $request)
    {
        $input = $request->validated();
        
        if ($request->input('submit') === 'submit') {
        } else {
            return redirect()->route('contact.add')->withInput($input);
        }

        $no = '';
        DB::transaction(function () use ($input, &$no) {
            $model = new Contact();
            $no = $model->insertContact($input);
        });
        
        return redirect()->route('contact.complete')->with('no', $no);
    }


    public function complete(Request $request)
    {
        if ($request->session()->has('no')) {
            $no = $request->session()->get('no');
        } else {
            return redirect()->route('top')->with('msg_failure', 'セッション期限が切れました。');
        }

        return view('contact.complete', compact('no'));
    }
    
}
