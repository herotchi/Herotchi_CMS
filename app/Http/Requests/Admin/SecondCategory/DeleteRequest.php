<?php

namespace App\Http\Requests\Admin\SecondCategory;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;

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
            'id' => 'bail|required|integer|exists:second_categories',
        ];
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {

                $data = $validator->valid();

                if ($validator->errors()->has('id')) {
                    $this->session()->flash('msg_failure', '不正な値が入力されました。');
                } else {// 削除対象の中カテゴリが製品と紐づいているかチェック
                    $model = new SecondCategory();
                    $secondCategory = $model->find($data['id']);

                    $resultProduct = $secondCategory->products()->exists();
                    if ($resultProduct) {
                        $validator->errors()->add('id', '製品と紐づいている中カテゴリは削除できません。');
                        $this->session()->flash('msg_failure', '製品と紐づいている中カテゴリは削除できません。');
                    }
                }
            }
        ];
    }
}
