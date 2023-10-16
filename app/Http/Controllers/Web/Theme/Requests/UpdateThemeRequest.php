<?php

namespace App\Http\Controllers\Web\Theme\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule as ValidationRule;

class UpdateThemeRequest extends FormRequest
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
        $rules['name'] =  ['string', 'required', 'max:255',  ValidationRule::unique('app_themes', 'name')->ignore($this->permission)];
        $rules['primary_color'] = ['required'];
        $rules['secondary_color'] = ['required'];
        $rules['tertiary_color'] = ['required'];
        $rules['seed_color'] = ['required'];



        return $rules;
    }
}
