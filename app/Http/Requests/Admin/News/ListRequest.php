<?php

namespace App\Http\Requests\Admin\News;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\NewsConsts;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class ListRequest extends FormRequest
{
    private $forms = [
        'title',
        'release_date_from',
        'release_date_to',
        'release_flg',
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
            'title' => 'bail|nullable|string|max:' . NewsConsts::TITLE_LENGTH_MAX,
            'release_date_from' => 'bail|nullable|date_format:Y-m-d|after_or_equal:2019/01/01|before_or_equal:2037/12/31',
            'release_date_to' => 'bail|nullable|date_format:Y-m-d|after_or_equal:2019/01/01|before_or_equal:2037/12/31|after_or_equal:release_date_from',
            'release_flg' => 'bail|nullable|array',
            'release_flg.*' => Rule::in(array_keys(NewsConsts::RELEASE_FLG_LIST)),
        ];
    }


    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key = null, $default = null);

        foreach ($this->forms as $form) {
            if (!Arr::exists($data, $form)) {
                if ($form === 'release_flg') {
                    $data[$form] = array();
                } else {
                    $data[$form] = null;
                }
            }
        }

        return $data;
    }
}
