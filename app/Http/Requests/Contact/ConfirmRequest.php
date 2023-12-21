<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\ContactConsts;

class ConfirmRequest extends FormRequest
{
    /**
     * バリデーション失敗時に、ユーザーをリダイレクトするルート
     *
     * @var string
     */
    protected $redirectRoute = 'contact.add';


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
            'name' => 'bail|required|string|max:' . ContactConsts::NAME_LENGTH_MAX,
            'mail_address' => 'bail|required|string|email:strict,dns,spoof|max:' . ContactConsts::MAIL_ADDRESS_LENGTH_MAX,
            'mail_body' => 'bail|required|string|max:' . ContactConsts::MAIL_BODY_LENGTH_MAX,
            'user_policy'  => 'bail|required|accepted',
        ];
    }


    /**
     * バリーデーションのためにデータを準備
     */
    protected function prepareForValidation(): void
    {
        $this->merge($this->session()->get('input'));
    }


    public function attributes()
    {
        return [
            'name' => '氏名'
        ];
    }
}
