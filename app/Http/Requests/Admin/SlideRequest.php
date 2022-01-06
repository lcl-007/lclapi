<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
class SlideRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required',
            'img'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'title.required'=>'标题不能为空',
            'img.required'=>'图片地址不能为空',
        ];
    }
}
