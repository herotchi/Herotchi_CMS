<?php

namespace App\Http\Requests\Admin\Contact;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

use App\Consts\ContactConsts;

class StatusUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'id' => 'bail|required|integer|exists:contacts',
            'status' => ['bail', 'required', 'integer', Rule::in(array_keys(ContactConsts::STATUS_LIST))],
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {

                if ($validator->errors()->has('id')) {
                    $this->session()->flash('msg_failure', '不正な値が入力されました。');
                }
            }
        ];
    }
}
