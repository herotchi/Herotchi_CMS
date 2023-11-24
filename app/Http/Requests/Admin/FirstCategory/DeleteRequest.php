<?php

namespace App\Http\Requests\Admin\FirstCategory;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;

use App\Models\FirstCategory;
use App\Models\SecondCategory;

class DeleteRequest extends FormRequest
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
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {
                $data = $validator->valid();

                // 削除対象の大カテゴリが中カテゴリや製品と紐づいているかチェック
                if (Arr::exists($data, 'id')) {
                    $model = new FirstCategory();
                    $firstCategory = $model->find($data['id']);
                    $resultSecondCategory = $firstCategory->second_categories()->exists();
                    if ($resultSecondCategory) {
                        $validator->errors()->add('second_category_id', '中カテゴリと紐づいている大カテゴリは削除できません。');
                    }

                    $resultProduct = $firstCategory->products()->exists();
                    if ($resultProduct) {
                        $validator->errors()->add('second_category_id', '製品と紐づいている大カテゴリは削除できません。');
                    }
                }
            }
        ];
    }
}
