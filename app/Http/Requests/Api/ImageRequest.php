<?php

namespace App\Http\Requests\Api;

class ImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'type' => ['required', 'string', 'in:avatar,topic']
        ];

        if ($this->type == 'avatar') {
            $rules['image'] = ['required', 'mimes:jpeg,png', 'dimensions:min_width=150,min_height=150'];
        } else {
            $rules['image'] = ['required', 'mimes:jpeg,png'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.dimensions' => '图片清晰度不够，宽和高需要150px'
        ];
    }
}
