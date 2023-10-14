<?php

namespace App\Http\Controllers\Web\Role\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
        $rules = array();
        $rules['name'] =  ['string', 'required', 'max:255', 'unique:roles,name'];
        $rules['guard_name'] = ['required'];



        return $rules;
    }
}
