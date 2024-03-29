<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        return [
            'name'=>'required|max:150|unique:roles,name,'.$this->getId(),
            'description' => 'required|max:250',
        ];
    }

    public function getId()
    {
        if (isset($this->role->id)) {
            return $this->role->id;
        } else {
            return null;
        }
    }

    public function messages()
    {
        return[
            'name.required' => 'name is required',
            'name.max' => 'Maximum character is 150',
            'name.unique' => 'This role name is taken before',
            'description.max' => 'Maximum character is 250',
            'description.required' => 'description is required',
        ];
    }
}
