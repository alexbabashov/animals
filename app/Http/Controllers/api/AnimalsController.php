<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Models\Animal;
use App\Common\ValidationRules;

class AnimalsController extends BaseController
{
    public function index()
    {
        $result = Animal::getAllKinds();
        Log::channel('api_animals')->debug('Get list kind: ', $result);
        return Response()->json($result);
    }


    public function show(Request $request)
    {
        $validFields = ValidationRules::validateRequest( $request,
                                [
                                    'kind' => ValidationRules::KIND,
                                ],
                                ValidationRules::ERR_MSG);

        $result = Animal::getKind($validFields);

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $validFields = ValidationRules::validateRequest( $request,
                                [
                                    'kind' => ValidationRules::KIND,
                                ],
                                ValidationRules::ERR_MSG);

        Animal::deleteByKind($validFields);
        $result = [
            'error' => null,
            'data' =>  null
        ];
        return Response()->json($result);
    }

    public function deleteAll(Request $request)
    {
        Animal::deleteAll();
        $result = [
            'error' => null,
            'data' =>  null
        ];
        return Response()->json($result);
    }

    // public function age(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'name' => ValidationRules::NAME
    //         ],
    //         ValidationRules::ERR_MSG
    //     );
    //     $fields = $validator->validated();
    //     if (isset($fields['name'])) {
    //         $result = ActiveAnimal::upAge($fields['name']);
    //     }

    //     return response()->json($result);
    // }

    // public function deleteAll(Request $request)
    // {
    //     ActiveAnimal::deleteAll();
    //     $result = [
    //         'error' => null,
    //         'data' =>  null
    //     ];
    //     return Response()->json($result);
    // }

    // public function deleteByName(Request $request)
    // {
    //     $errMsg = null;
    //     $validFields = self::validateRequest( $request,
    //                             [
    //                                 'name' => ValidationRules::NAME,
    //                             ],
    //                             ValidationRules::ERR_MSG );

    //     if (isset($validFields['error'])) {
    //         $errMsg = $validFields['error'];
    //     } else {
    //         $isDelete = ActiveAnimal::deleteByName($validFields['fields']['name']);
    //         if (!$isDelete) {
    //             $errMsg = 'not found';
    //         }
    //     }
    //     $result = [
    //         'error' => $errMsg,
    //         'data' => null
    //     ];
    //     return response()->json($result);
    // }
}
