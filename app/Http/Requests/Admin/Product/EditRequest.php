<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Models\SecondCategory;

use App\Consts\ProductConsts;

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
            'id' => 'bail|required|integer|exists:products',
            'first_category_id' => 'bail|required|integer|exists:first_categories,id',
            'second_category_id' => 'bail|required|integer|exists:second_categories,id',
            'name' => 'bail|required|string|max:' . ProductConsts::NAME_LENGTH_MAX,
            // 画像ファイルは過去にアップロードされたファイルをそのまま使う可能性がある
            'image' => 'bail|nullable|file|image|mimes:jpg,png|max:' . ProductConsts::IMAGE_FILE_MAX,
            'detail' => 'bail|required|string|max:' . ProductConsts::DETAIL_LENGTH_MAX,
            'release_flg' => ['bail', 'required', 'integer', Rule::in(array_keys(ProductConsts::RELEASE_FLG_LIST))],
        ];
    }


    public function attributes()
    {
        return [
            'name' => '製品名',
            'image' => '製品画像'
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

                // 製品の大カテゴリと中カテゴリが紐づいているかチェック
                if (Arr::exists($data, 'first_category_id') && Arr::exists($data, 'second_category_id')) {
                    $model = new SecondCategory();
                    $result = $model
                        ->where('first_category_id', $data['first_category_id'])
                        ->where('id', $data['second_category_id'])
                        ->exists();

                    if (!$result) {
                        $validator->errors()->add('second_category_id', '大カテゴリと紐づいていない中カテゴリが選択されました。');
                    }
                }
            }
        ];
    }
}
