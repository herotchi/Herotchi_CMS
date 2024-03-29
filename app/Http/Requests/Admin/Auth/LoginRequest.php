<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\AuthConsts;

class LoginRequest extends FormRequest
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
            'login_id' => 'required|max:' . AuthConsts::LOGIN_ID_LENGTH_MAX,
            'password' => 'required|max:' . AuthConsts::PASSWORD_LENGTH_MAX,
        ];
    }
}
