<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\UserConsts;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Rules\AlphaNumDashUnder;

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
            'login_id'  => ['bail', 'required', 'string', new AlphaNumDashUnder, 'min:' . UserConsts::LOGIN_ID_LENGTH_MIN, 'max:' . UserConsts::LOGIN_ID_LENGTH_MAX, Rule::unique('users')->ignore(Auth::user()->login_id, 'login_id')],
            'password'  => ['bail', 'nullable', 'string', new AlphaNumDashUnder, 'min:' . UserConsts::PASSWORD_LENGTH_MIN, 'max:' . UserConsts::PASSWORD_LENGTH_MAX, 'confirmed'],
        ];
    }
}
