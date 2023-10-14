<?php

namespace App\Http\Controllers\Web\Role\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule as ValidationRule;

class UpdateRoleRequest extends FormRequest
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
        Log::info($this->role);

        $rules = array();
        $rules['name'] =  ['string', 'required', 'max:255',  ValidationRule::unique('roles', 'name')->ignore($this->role)];
        $rules['guard_name'] = ['required'];



        return $rules;
    }
}
