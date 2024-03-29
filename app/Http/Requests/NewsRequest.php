<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\NewsType;
use BenSampo\Enum\Rules\EnumValue;

class NewsRequest extends FormRequest
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
            'main_title'=>'required|max:150|min:3',
            'secondary_title'=>'max:150|min:3',
            'content' =>'required|string',
            'type'=>['required', new EnumValue(NewsType::class, false)],
            'staff_id'=>'required|exists:staff,id',
            'related'  => 'array|max:10',
           
        ];
    }
}
