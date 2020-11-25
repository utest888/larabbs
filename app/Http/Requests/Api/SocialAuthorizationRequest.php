<?php

namespace App\Http\Requests\Api;

class SocialAuthorizationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'code' => ['required_without:access_token', 'string'],
            'access_token' => ['required_without:code', 'string']
        ];
    }
}
