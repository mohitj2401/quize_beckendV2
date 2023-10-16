<?php

namespace App\Http\Controllers\Web\Theme\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateThemeRequest extends FormRequest
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
        $rules['name'] =  ['string', 'required', 'max:255', 'unique:app_themes,name'];
        $rules['primary_color'] = ['required'];
        $rules['secondary_color'] = ['required'];
        $rules['tertiary_color'] = ['required'];
        $rules['seed_color'] = ['required'];




        return $rules;
    }
}
