<?php

namespace App\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationRules
{
    public const NAME = [
        'required',
        'string',
        'min:3',
        'max:255'
    ];

    public const KIND = [
        'required',
        'string',
        'min:3',
        'max:255'
    ];

    public const ERR_MSG = [
        'name.required' => ':attribute обязательное поле',
        'name.string'   => ':attribute должна быть строка',
        'name.min'      => ':attribute минимальная длина :min',
        'name.max'      => ':attribute максимальная длина :max',

        'kind.required' => ':attribute обязательное поле',
        'kind.string'   => ':attribute должна быть строка',
        'kind.min'      => ':attribute минимальная длина :min',
        'kind.max'      => ':attribute максимальная длина :max',
    ];


    public static function validateRequest(Request $request,
                                            Array $rulles,
                                            Array $rullesMsg )
    {
        $errMsg = null;

        $validator = Validator::make(
                                        $request->all(),
                                        $rulles,
                                        $rullesMsg
                                    );
        $errors = $validator->errors();
        foreach ($errors->all() as $message) {
            $errMsg .= $message . ' ';
        }

        $result = [
            'error' => $errMsg,
            'fields' => $validator->validated()
        ];

        return $result;
    }
}
