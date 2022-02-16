<?php

namespace App\Http\Requests;

use App\Common\ValidationRules;
//use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AnimalsGetByKindRequest extends Request
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
                    'kind' => ValidationRules::KIND,                   
                ];
    }

    public function messages()
    {
        return ValidationRules::ERR_MSG;
    }

    public function attributes()
    {
        return [
            'name' => 'Имя животного',
            'kind' => 'Вид животного',
        ];
    }
}
