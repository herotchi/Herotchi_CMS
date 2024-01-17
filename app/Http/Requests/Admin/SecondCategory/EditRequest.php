<?php

namespace App\Http\Requests\Admin\SecondCategory;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;
use App\Models\SecondCategory;

use App\Consts\SecondCategoryConsts;

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
            'id' => 'bail|required|integer|exists:second_categories',
            'first_category_id' => 'bail|required|integer|exists:first_categories,id',
            'name' => 'bail|required|string|max:' . SecondCategoryConsts::NAME_LENGTH_MAX,
        ];
    }


    public function attributes()
    {
        return [
            'name' => '中カテゴリ名',
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {
                $data = $validator->valid();

                if ($validator->errors()->has('id')) {
                    $this->session()->flash('msg_failure', '不正な値が入力されました。');
                }

                // 元の自分自身の中カテゴリ名を除く、中カテゴリ名と入力値が重複しているかチェック
                // ただし、紐づいている大カテゴリが違う場合は重複とならない
                if ($validator->errors()->has('id') === false 
                && $validator->errors()->has('first_category_id') === false
                && $validator->errors()->has('name') === false) {
                    $model = new SecondCategory();
                    $secondCategory = $model->where('first_category_id', $data['first_category_id'])->where('name', $data['name'])->first();
                    if ($secondCategory && ((string)$secondCategory->id !== $data['id'])) {
                        $validator->errors()->add('name', '同じ大カテゴリ内で中カテゴリ名が重複しています。');
                    }
                }
            }
        ];
    }
}
