<?php

namespace App\Http\Requests\Admin\FirstCategory;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;
use App\Models\FirstCategory;

use App\Consts\FirstCategoryConsts;

class EditRequest extends FormRequest
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
            'id' => 'bail|required|integer|exists:first_categories',
            'name' => 'bail|required|string|max:' . FirstCategoryConsts::NAME_LENGTH_MAX,
        ];
    }


    public function attributes()
    {
        return [
            'name' => '大カテゴリ名',
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {
                $data = $validator->valid();

                // 元の自分自身の大カテゴリ名を除く、大カテゴリ名と入力値が重複しているかチェック
                if (Arr::exists($data, 'id') && Arr::exists($data, 'name')) {
                    $model = new FirstCategory();
                    $firstCategory = $model->where('name', $data['name'])->first();
                    if ($firstCategory && ((string)$firstCategory->id !== $data['id'])) {
                        $validator->errors()->add('name', '大カテゴリ名が重複しています。');
                    }
                }
            }
        ];
    }
}
