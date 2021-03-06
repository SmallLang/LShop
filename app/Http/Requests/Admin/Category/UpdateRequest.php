<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getMethod() == 'GET' ? [] : [
            'name' => 'required',
            'parent_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '分类名不能为空',
            'parent_id.required' => '请选择一个父级分类',
            'parent_id.numeric' => '请选择一个父级分类',
        ];
    }
}
