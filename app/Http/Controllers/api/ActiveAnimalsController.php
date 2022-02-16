<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController;
use App\Models\ActiveAnimal;
use App\Common\ValidationRules;

class ActiveAnimalsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ActiveAnimal::listAll();

        return Response()->json($result);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validFields = ValidationRules::validateRequest( $request,
                                [
                                    'name' => ValidationRules::NAME,
                                    'kind' => ValidationRules::KIND,
                                ],
                                ValidationRules::ERR_MSG);
        $result = ActiveAnimal::addAnimal($validFields);

        return response()->json($result);
    }

    public function show(Request $request)
    {
        $errMsg = null;
        $data = null;
        $validFields = ValidationRules::validateRequest( $request,
                                [
                                    'name' => ValidationRules::NAME,
                                ],
                                ValidationRules::ERR_MSG);

        if (isset($validFields['error'])) {
            $errMsg = $validFields['error'];
        } else {
            $data = ActiveAnimal::getByName($validFields['fields']['name'], false);
            $errMsg = $data ? null : 'not found';
        }
        $result = [
            'error' => $errMsg,
            'data' => $data
        ];
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $validFields = ValidationRules::validateRequest( $request,
                                [
                                    'name' => ValidationRules::NAME,
                                ],
                                ValidationRules::ERR_MSG);

        if (isset($validFields['error'])) {
            $result = [
                'error' => $validFields['error'],
                'data' => null
            ];
        } else {
            $result = ActiveAnimal::upAge($validFields['fields']['name']);// getByName($validFields['fields']['name'], false);
        }
        return response()->json($result);
    }

    public function deleteAll(Request $request)
    {
        ActiveAnimal::deleteAll();
        $result = [
            'error' => null,
            'data' => null
        ];
        return response()->json($result);
    }

    public function deleteByName(Request $request)
    {
        $validFields = ValidationRules::validateRequest( $request,
                            [
                                'name' => ValidationRules::NAME,
                            ],
                            ValidationRules::ERR_MSG);

        if (isset($validFields['error'])) {
            $result = [
                'error' => $validFields['error'],
                'data' => null
            ];
        } else {
            $result = ActiveAnimal::deleteByName($validFields['fields']['name']);
        }

        return response()->json($result);
    }
}
