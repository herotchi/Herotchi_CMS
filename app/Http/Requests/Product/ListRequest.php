<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Validator;
use Illuminate\Support\Arr;
use App\Models\Product;

use App\Consts\ProductConsts;

class ListRequest extends FormRequest
{
    private $forms = [
        'first_category_id',
        'second_category_id',
        'keyword',
    ];


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
            'keyword' => 'bail|nullable|string|max:' . ProductConsts::KEYWORD_LENGTH_MAX,
            'first_category_id' => 'bail|nullable|integer|exists:first_categories,id',
            'second_category_id' => 'bail|nullable|integer|exists:second_categories,id',
        ];
    }


    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key = null, $default = null);

        foreach ($this->forms as $form) {
            if (!Arr::exists($data, $form)) {
                $data[$form] = null;
            }
        }

        return $data;
    }


    public function after(): array
    {
        return [
            function (Validator $validator) {
                $data = $validator->valid();

                // 製品の大カテゴリと中カテゴリが紐づいているかチェック
                if (Arr::exists($data, 'first_category_id') && Arr::exists($data, 'second_category_id') && $data['first_category_id'] && $data['second_category_id']) {
                    $model = new Product();
                    $result = $model
                        ->where('first_category_id', $data['first_category_id'])
                        ->where('second_category_id', $data['second_category_id'])
                        ->where('release_flg', ProductConsts::RELEASE_FLG_ON)
                        ->exists();

                    if (!$result) {
                        $validator->errors()->add('second_category_id', '大カテゴリと紐づいていない中カテゴリが選択されました。');
                    }

                    if ($validator->errors()->any()) {
                        $this->session()->flash('msg_failure', '不正な値が入力されました。');
                    }
                }
            }
        ];
    }
}
