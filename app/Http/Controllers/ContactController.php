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

        DB::transaction(function () use ($input) {
            $model = new Contact();
            $model->insertContact($input);
        });
        
        return redirect()->route('contact.complete');
    }


    public function complete()
    {
        return view('contact.complete');
    }
    
}
