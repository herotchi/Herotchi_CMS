<?php

namespace App\Http\Requests\Admin\SecondCategory;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\SecondCategoryConsts;

class AddRequest extends FormRequest
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
            'first_category_id' => 'bail|required|integer|exists:first_categories,id',
            'name' => 'bail|required|string|max:' . SecondCategoryConsts::NAME_LENGTH_MAX,
        ];
    }
}
