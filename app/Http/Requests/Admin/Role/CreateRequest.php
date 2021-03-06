<?php

namespace App\Http\Requests\Admin\Role;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Route;

class CreateRequest extends Request
{

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
            'name' => 'required|max:100|',
            'display_name' => 'sometimes|max:100',
            'description' => 'sometimes|max:100',
            'role_permission' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '角色名称必须',
            'name.max' => '角色名称最多100个字符',
            'display_name.max' => '角色显示名称最多100个字符',
            'description.max' => '角色说明最多100字符',
            'role_permission.required' => '角色最少需要一个权限',
        ];
    }
}
